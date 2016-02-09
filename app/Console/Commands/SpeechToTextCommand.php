<?php

namespace App\Console\Commands;

use App\Models\Podcast;
use Brideo\IbmWatson\Ibm\Config;
use Brideo\IbmWatson\Ibm\SpeechToText;
use Exception;
use Illuminate\Console\Command;

class SpeechToTextCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'podcast:speechToText';


    protected $description = 'Convert podcasts to text';

    /**
     * @var SpeechToText
     */
    protected $speechToText;

    /**
     * @return $this
     */
    public function fire()
    {
        $config = new Config();
        $config->setUsername(env('IBM_SPEECH_TO_TEXT_USERNAME'));
        $config->setPassword(env('IBM_SPEECH_TO_TEXT_PASSWORD'));

        $speechToText = new SpeechToText($config);

        /** @var \Illuminate\Database\Eloquent\Builder $podcasts */
        $podcasts = Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_FILE_CONVERTED);
        foreach ($podcasts->get() as $podcast) {

            /** @var Podcast $podcast */
            $fileName = $podcast->getAttribute(Podcast::COLUMN_CONVERTED_FILE);
            $speechToText->recognize(storage_path("app/{$fileName}"));

            try {

                foreach ($speechToText->getTranscripts() as $transcript) {

                    $podcast->setAttribute(Podcast::COLUMN_TRANSCRIPTION, $transcript);
                    $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_AUDIO_TO_TEXT_CONVERTED);
                    $podcast->save();

                    break;
                }
            } catch (Exception $e) {

                $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_AUDIO_TO_TEXT_CONVERSION_FAILED);
                $podcast->save();
                $this->error($e->getMessage());

                continue;
            }
        }

        return $this;
    }
}
