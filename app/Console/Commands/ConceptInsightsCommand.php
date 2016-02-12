<?php

namespace App\Console\Commands;

use App\Models\Podcast;
use App\Services\Podcasts\Corpus;
use Brideo\IbmWatson\Ibm\Config;
use Brideo\IbmWatson\Ibm\Ibm;
use Exception;
use Illuminate\Console\Command;

class ConceptInsightsCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'podcast:conceptInsights';

    protected $description = 'Submit transcriptions to the IBM Corpus';

    /**
     * @return $this
     */
    public function fire()
    {

        $corpus = new Corpus();

        /** @var \Illuminate\Database\Eloquent\Builder $podcasts */
        $podcasts = Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_AUDIO_TO_TEXT_CONVERTED);
        foreach ($podcasts->get() as $podcast) {
            /** @var Podcast $podcast */
            try {

                $corpus->createDocumentFromPodcast($podcast);
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
