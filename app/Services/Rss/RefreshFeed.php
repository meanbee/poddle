<?php

namespace App\Services\Rss;

use App\Models\Rss;
use App\Models\Podcast;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use ezcFeed;
use ezcFeedParseErrorException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Mockery\CountValidator\Exception;

/**
 * Class RefreshFeed
 *
 * Check feeds for new podcast updates
 *
 * @package App\Services\Podcasts
 */
class RefreshFeed
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
        /** @var Rss[] $rss */
        Rss::whereDate(Rss::COLUMN_LAST_SYNC, '<=', date('Y-m-d H:i:s'))
            ->orWhereNull(Rss::COLUMN_LAST_SYNC)
            ->chunk(100, function ($rssChunk) {

                /** @var Rss $rss */
                foreach ($rssChunk as $rss) {

                    try {
                        $response = $this->httpClient->get($rss->getAttribute(Rss::COLUMN_URL));
                        $contents = $response->getBody()->getContents();

                        if ($response->getStatusCode() != 200 || $contents == '') {
                            $this->refreshFinish($rss);
                            continue;
                        }
                    } catch (ConnectException $e) {
                        continue;
                    } catch (RequestException $e) {
                        continue;
                    }


                    try {
                        $feed = ezcFeed::parseContent($contents);

                        $this->updateFeedInfo($rss, $feed);
                        $this->checkForNewEpisodes($rss, $feed);
                        $this->refreshFinish($rss);

                    } catch (ezcFeedParseErrorException $e) {
                        continue;
                    } catch (Exception $e) {
                        continue;
                    }
                }
            });
    }

    /**
     * Update top level RSS information from feed
     *
     * @param Rss $rss
     * @param ezcFeed $feed
     */
    private function updateFeedInfo($rss, $feed)
    {
        $title = isset($feed->title) ? $feed->title : null;
        $description = isset($feed->description) ? $feed->description : null;

        $author = null;
        if (isset($feed->author)) {
            if (isset($feed->author->name)) {
                $author = $feed->author->name;
            } elseif (is_array($feed->author)) {
                $author = $feed->author[0]->name;
            }
        }

        $category = isset($feed->category) ? $feed->category : null;

        if (is_array($category)) {
            $categories = array();
            foreach ( $category as $childCategory ) {
                $categories[] = $childCategory->term;
                if (isset($childCategory->category)) {
                    $categories[] = $childCategory->category->term;
                }
            }

            $categories = array_unique($categories);
            $category = json_encode(array_values($categories));
        }

        $image = isset($feed->image->url) ? $feed->image->url : null;

        $link = isset($feed->link) ? $feed->link[0]->href : null;
        $buildDate = isset($feed->updated->date) ? $feed->updated->date : null;


        if ($feed->hasModule('iTunes')) {
            $itunes = $feed->iTunes;
            $author = (isset($itunes->author) && !$author) ? $itunes->author : $author;
            $link = (isset($itunes->link) && !$link) ? $itunes->link : $link;

            if (isset($itunes->category)) {
                $categories = array();
                foreach ( $itunes->category as $category ) {
                    $categories[] = $category->term;
                    if (isset($category->category)) {
                        $categories[] = $category->category->term;
                    }
                }

                $categories = array_unique($categories);
                $category = json_encode(array_values($categories));
            }
        }


        $rss->setAttribute(Rss::COLUMN_NAME, $title);
        $rss->setAttribute(Rss::COLUMN_DESCRIPTION, $description);
        $rss->setAttribute(Rss::COLUMN_AUTHOR, $author);
        $rss->setAttribute(Rss::COLUMN_CATEGORY, $category);
        $rss->setAttribute(Rss::COLUMN_IMAGE, $image);
        $rss->setAttribute(Rss::COLUMN_LINK, $link);
        $rss->setAttribute(Rss::COLUMN_BUILD_DATE, $buildDate);
    }

    /**
     * Check for new episodes
     *
     * @param Rss $rss
     * @param ezcFeed $feed
     */
    private function checkForNewEpisodes($rss, $feed)
    {
        if (!isset($feed->item)) {
            return;
        }

        foreach ($feed->item as $item) {

            $publishedDate = isset( $item->published ) ? $item->published->date : null;

            $latestEpisode = $this->getLatestEpisode($rss);
            if ($latestEpisode && $latestEpisode->getAttribute(Podcast::COLUMN_PUBLISHED_DATE) >= $publishedDate ){
                // We've already seen items this old, so ignore any others.
                return;
            }

            $guid = isset($item->id) ? $item->id : null;
            $title = isset($item->title) ? $item->title : null;
            $description = isset($item->description) ? $item->description : null;

            $author = null;
            if (isset($item->author)) {
                if (isset($item->author->name)) {
                    $author = $item->author->name;
                } elseif (is_array($item->author)) {
                    $author = $item->author[0]->name;
                }
            }

            $link = isset($item->link) ? $item->link[0]->href : null;

            $type = null;
            if (isset($item->enclosure)) {
                $enclosure = $item->enclosure[0];
                $url = isset($enclosure->url) ? $enclosure->url : null;
                $type = isset($enclosure->type) ? $enclosure->type : null;
            }

            if (!isset($url) || !isset($guid)) {
                // If no file URL or ID, we're not interested
                continue;
            }

            $urlExists = Podcast::where(Podcast::COLUMN_URL, '=', $url)->count();
            $guidExists = Podcast::where(Podcast::COLUMN_GUID, '=', $guid)->count();
            if ($urlExists || $guidExists) {
                continue;
            }

            $podcast = new Podcast();
            $podcast->setAttribute(Podcast::COLUMN_RSS_ID, $rss->id);
            $podcast->setAttribute(Podcast::COLUMN_PODCAST_NAME, $rss->getAttribute(Rss::COLUMN_NAME));
            $podcast->setAttribute(Podcast::COLUMN_GUID, $guid);
            $podcast->setAttribute(Podcast::COLUMN_URL, $url);
            $podcast->setAttribute(Podcast::COLUMN_ORIGINAL_FILE_TYPE, $type);
            $podcast->setAttribute(Podcast::COLUMN_STATUS, Podcast::STATUS_NEW);
            $podcast->setAttribute(Podcast::COLUMN_EPISODE_NAME, $title);
            $podcast->setAttribute(Podcast::COLUMN_AUTHOR, $author);
            $podcast->setAttribute(Podcast::COLUMN_DESCRIPTION, $description);
            $podcast->setAttribute(Podcast::COLUMN_PUBLISHED_DATE, $publishedDate);
            $podcast->setAttribute(Podcast::COLUMN_LINK, $link);
            $podcast->save();
        }
    }

    /**
     * Get latest episode for individual RSS
     *
     * @param Rss $rss
     * @return Podcast|bool
     */
    private function getLatestEpisode($rss)
    {
        $podcast = $rss->podcasts()->orderBy('published_date', 'desc')->first();

        if ($podcast) {
            return $podcast;
        }

        return false;
    }

    /**
     * Mark refresh as finished
     *
     * @param Rss $rss
     */
    private function refreshFinish($rss)
    {
        $rss->setAttribute(Rss::COLUMN_LAST_SYNC, date('Y-m-d H:i:s'));
        $rss->save();
    }
}
