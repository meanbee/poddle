<?php

use App\Models\Rss;
use Illuminate\Database\Seeder;
use Celd\Opml\Importer;


class RssTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->importRss('http://feeds.feedburner.com/MageTalkAMagentoPodcast', 'MageTalk: A Magento Podcast');
        $this->importRss('http://llamacommerceshow.libsyn.com/rss', 'The Llama Commerce Show');
        $this->importRss('http://www.giantbomb.com/podcast-xml/giant-bombcast', 'Giant Bomb');
        $this->importRss('http://www.webagencypodcast.com/feed/', 'Web Agency Podcast');
        $this->importRss('http://feeds.feedburner.com/thetimferrissshow', 'Tim Ferris');

        $this->importOpml('digitalpodcasttopratednoadult.opml');
        $this->importOpml('digitalpodcastmostviewednoadult.opml');
        $this->importOpml('digitalpodcastmostsubscribednoadult.opml');
        $this->importOpml('bbc_podcasts.opml');
        $this->importOpml('matiassingers_podcasts.opml');
        $this->importOpml('ticktockhouse_podcasts.opml');
        $this->importOpml('e2jk_podcasts.opml');
        $this->importOpml('djui_podcasts.opml');
    }

    /**
     * Import RSS feeds from Opml file
     *
     * @param String $file
     */
    private function importOpml($file) {
        $doc = new DOMDocument();
        $doc->load(dirname(__FILE__) . '/' . $file);

        /** @var DomElement $outline */
        foreach ($doc->getElementsByTagName('outline') as $outline) {
            if (!$outline->getAttribute('type')) {
                continue;
            }

            $title = trim($outline->getAttribute('text'));


            if ($outline->getAttribute('type') == 'link') {
                $url = trim($outline->getAttribute('url'));
            }

            if ($outline->getAttribute('type') == 'rss') {
                $url = trim($outline->getAttribute('xmlHref'));
            }

            if (isset($url)) {
                $this->importRss($url, $title);
            }
        }
    }

    /**
     * Import Rss
     *
     * @param $url
     * @param $title
     */
    private function importRss($url, $title)
    {
        $exists = Rss::where(Rss::COLUMN_URL, '=', $url)->count();
        if ($exists || $url == '') {
            return;
        }

        $rss = new Rss();
        $rss->setAttribute(Rss::COLUMN_URL, $url);
        $rss->setAttribute(Rss::COLUMN_NAME, $title);
        $rss->save();
    }
}
