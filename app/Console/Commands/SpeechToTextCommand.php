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

        Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_FILE_CONVERTED)
            ->chunk(10, function ($podcasts) use ($speechToText) {

                /** @var Podcast $podcast */
                foreach ($podcasts as $podcast) {

                    /** @var Podcast $podcast */
                    $fileName = $podcast->getConvertedFile();

                    try {
                        $speechToText->recognize(storage_path("app/$fileName"));
                        $transcriptString = '';

                        foreach ($speechToText->getTranscripts() as $transcript) {
                            $transcriptString .= $transcript;
                        }

                        $podcast->setTranscription($transcriptString);
                        $podcast->setStatus(Podcast::STATUS_AUDIO_TO_TEXT_CONVERTED);
                        $podcast->save();
                        $speechToText->deleteSession();

                    } catch (Exception $e) {

                        $podcast->setStatus(Podcast::STATUS_AUDIO_TO_TEXT_CONVERSION_FAILED);
                        $podcast->save();
                        $this->error($e->getMessage());

                        continue;
                    }
                }
            });

        return $this;
    }
}
