<?php

namespace App\Services\Podcasts;

use App\Models\Podcast;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

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

    /**
     * Limit the number of podcasts downloaded per run
     */
    protected $limit;

    public function __construct(ClientInterface $httpClient = null, $limit = 10)
    {
        $this->httpClient = $httpClient ?: new Client();
        $this->limit = $limit;
    }


    /**
     * Find any new podcasts and download file to local storage
     */
    public function run(){

        /** @var Podcast[] $podcasts */
        $podcasts = Podcast::where(Podcast::COLUMN_STATUS, '=', Podcast::STATUS_NEW)
            ->orderBy(Podcast::COLUMN_PUBLISHED_DATE, 'desc')
            ->take($this->limit)
            ->get();

        foreach ($podcasts as $podcast) {

            $url = $podcast->getUrl();
            $filename = last(explode('/', $url));
            $path = storage_path('app/' . $filename);

            try {
                $response = $this->httpClient->request('GET', $url, ['sink' => $path]);

                if ($response->getStatusCode() == 200 ) {
                    $podcast->setStatus(Podcast::STATUS_DOWNLOADED);
                    $podcast->setOriginalFile($filename);
                } else {
                    $podcast->setStatus(Podcast::STATUS_DOWNLOAD_FAILED);
                }
            } catch (ClientException $e) {
                $podcast->setStatus(Podcast::STATUS_DOWNLOAD_FAILED);
            }

            $podcast->save();
        }
    }
}
