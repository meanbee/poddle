<?php

namespace App\Services\Podcasts;

use App\Models\Podcast;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class ConvertMp3ToOpus
 *
 * Handles converson of original MP3 podcast files to Opus
 *
 * @package App\Services\Podcasts
 */
class ConvertMp3ToOpus
{

    /** @var Client */
    protected $httpClient;

    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client();
    }

    /**
     * Find any new podcasts and download file to local storage
     */
    public function run()
    {
        /** @var Podcast[] $podcasts */
        Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_DOWNLOADED)
            ->chunk(100, function ($podcasts) {

                /** @var Podcast $podcast */
                foreach ($podcasts as $podcast) {

                    $output = '';
                    $returnCode = -1;
                    $origPath = storage_path('app/' . $podcast->getAttribute(Podcast::COLUMN_ORIGINAL_FILE));
                    $filenameInfo = pathinfo($origPath);
                    $newFilename = $filenameInfo['filename'] . '.opus';
                    $finalPath = storage_path('/app/' . $newFilename);
                    exec("avconv -i $origPath -f wav - | opusenc --bitrate 256 - $finalPath 2> /dev/null", $output, $returnCode);

                    if ($returnCode !== 0) {
                        $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_FILE_CONVERSION_FAILED);
                        $podcast->save();
                        continue;
                    }

                    $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_FILE_CONVERTED);
                    $podcast->setAttribute(Podcast::COLUMN_CONVERTED_FILE, $newFilename);
                    $podcast->save();
                }
            });
    }
}
