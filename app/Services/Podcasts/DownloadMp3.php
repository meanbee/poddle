<?php

namespace App\Services\Podcasts;

use App\Models\Podcast;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class DownloadMp3
 *
 * Handles downloading of original podcast files
 *
 * @package App\Services\Podcasts
 */
class DownloadMp3
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
    public function run(){

        /** @var Podcast[] $podcasts */
        $podcasts = Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_NEW)->get();

        foreach ($podcasts as $podcast) {

            $url = $podcast->getAttribute(Podcast::COLUMN_URL);
            $filename = last(explode('/', $url));
            $path = storage_path('app/' . $filename);

            $response = $this->httpClient->request('GET', $url, ['sink' => $path]);

            if ($response->getStatusCode() == 200 ) {
                $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_DOWNLOADED);
                $podcast->setAttribute(Podcast::COLUMN_ORIGINAL_FILE, $filename);
            } else {
                $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_DOWNLOAD_FAILED);
            }

            $podcast->save();
        }
    }
}
