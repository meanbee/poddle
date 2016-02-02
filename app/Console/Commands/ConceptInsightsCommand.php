<?php

namespace App\Console\Commands;

use App\Models\Podcast;
use Brideo\IbmWatson\Ibm\ConceptInsights\Corpus;
use Brideo\IbmWatson\Ibm\Config;
use Brideo\IbmWatson\Ibm\Ibm;
use Exception;
use Illuminate\Console\Command;

class ConceptInsightsCommand extends Command
{

    const CORPUS_NAME = 'podcast_index';

    /**
     * @var string
     */
    protected $name = 'ibm:conceptInsights';

    /**
     * @var Corpus
     */
    protected $corpus;

    /**
     * ConceptInsightsCommand constructor.
     *
     * @param Corpus $corpus
     *
     * @internal param Corpus|null $document
     */
    public function __construct(Corpus $corpus = null)
    {
        if (!$corpus) {
            $config = new Config();
            $config->setUsername(env('IBM_CONCEPT_INSIGHTS_USERNAME'));
            $config->setPassword(env('IBM_CONCEPT_INSIGHTS_PASSWORD'));

            $corpus = new Corpus(static::CORPUS_NAME, Ibm::DEFAULT_REQUEST_METHOD, $config);
        }

        $this->corpus = $corpus;

        parent::__construct();
    }

    /**
     * @return $this
     */
    public function fire()
    {
        /** @var \Illuminate\Database\Eloquent\Builder $podcasts */
        $podcasts = Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_AUDIO_TO_TEXT_CONVERTED);
        foreach ($podcasts->get() as $podcast) {
            /** @var Podcast $podcast */
            try {

                $this->corpus->createDocument($podcast->getAttribute(Podcast::COLUMN_EPISODE_NAME));

                $document = $this->corpus->getDocument($podcast->getAttribute(Podcast::COLUMN_EPISODE_NAME));

                $data = [
                    'label'       => $podcast->getAttribute(Podcast::COLUMN_PODCAST_NAME),
                    'parts'       => [
                        [
                            'data'         => $podcast->getAttribute(Podcast::COLUMN_TRANSCRIPTION),
                            'name'         => 'Text part',
                            'content-type' => 'text/html'
                        ]
                    ],
                    'user_fields' => [
                        $podcast->getAttribute(Podcast::COLUMN_EPISODE_NAME) => $podcast->getMetaData()
                    ],
                ];

                $document->config->setConfig('body', json_encode($data));

                $document->create();

                $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_TEXT_CONCEPTS_IDENTIFIED);
                $podcast->save();

            } catch (Exception $e) {
                $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_TEXT_CONCEPTS_IDENTIFICATION_FAILED);
                $podcast->save();
                $this->error($e->getMessage());
            }

        }

        return $this;
    }
}