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
    protected $name = 'ibm:speechToText';

    /**
     * @var SpeechToText
     */
    protected $speechToText;

    public function __construct(SpeechToText $speechToText = null)
    {
        if (!$speechToText) {
            $config = new Config();
            $config->setUsername(env('IBM_SPEECH_TO_TEXT_USERNAME'));
            $config->setPassword(env('IBM_SPEECH_TO_TEXT_PASSWORD'));

            $speechToText = new SpeechToText($config);
        }

        $this->speechToText = $speechToText;

        parent::__construct();
    }

    /**
     * @return $this
     */
    public function fire()
    {
        /** @var \Illuminate\Database\Eloquent\Builder $podcasts */
        $podcasts = Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_FILE_CONVERTED);
        foreach ($podcasts->get() as $podcast) {

            /** @var Podcast $podcast */
            $fileName = $podcast->getAttribute(Podcast::COLUMN_CONVERTED_FILE);
            $this->speechToText->recognize(storage_path("app/{$fileName}"));

            try {

                foreach ($this->speechToText->getTranscripts() as $transcript) {

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
