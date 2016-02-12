<?php

namespace App\Services\Podcasts;

use App\Models\Podcast;
use Brideo\IbmWatson\Ibm\Api\ConfigInterface;
use Brideo\IbmWatson\Ibm\Config;
use Brideo\IbmWatson\Ibm\Factory\ConceptInsights\CorpusFactory;

class Corpus
{

    const CORPUS_NAME = 'podcast_index';
    const DEFAULT_REQUEST_METHOD = '';

    public $corpus;

    /**
     * Corpus constructor.
     *
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config = null)
    {
        if (!$config) {
            $config = new Config();
            $config->setUsername(env('IBM_CONCEPT_INSIGHTS_USERNAME'));
            $config->setPassword(env('IBM_CONCEPT_INSIGHTS_PASSWORD'));
        }

        $this->corpus = CorpusFactory::create(static::CORPUS_NAME, Corpus::DEFAULT_REQUEST_METHOD, $config);
    }

    /**
     * @param Podcast $podcast
     *
     * @return $this
     */
    public function createDocumentFromPodcast(Podcast $podcast)
    {
        $this->corpus->createDocument($podcast->getAttribute(Podcast::COLUMN_EPISODE_NAME));

        $document = $this->corpus->getDocument($podcast->getAttribute(Podcast::COLUMN_EPISODE_NAME));

        $data = [
            'id'          => $podcast->getAttribute(Podcast::COLUMN_ID),
            'label'       => $podcast->getAttribute(Podcast::COLUMN_PODCAST_NAME),
            'parts'       => [
                [
                    'data'         => $podcast->getAttribute(Podcast::COLUMN_TRANSCRIPTION),
                    'name'         => 'Text part',
                    'content-type' => 'text/html'
                ]
            ],
            'user_fields' => [
                $podcast->getAttribute(Podcast::COLUMN_EPISODE_NAME) => $podcast->getAttribute(Podcast::COLUMN_META)
            ],
        ];

        $document->config->setConfig('body', json_encode($data));

        $document->create();

        return $this;
    }

    /**
     * @param $keyword
     *
     * @return mixed
     */
    public function searchCorpus($keyword)
    {
        $matches = $this->corpus->getLabelSearch($keyword);
        $matches = $matches->getBody()->getContents();
        return $matches;
    }
}
