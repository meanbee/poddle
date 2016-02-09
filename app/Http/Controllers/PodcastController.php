<?php

namespace App\Http\Controllers;

use App\Console\Commands\ConceptInsightsCommand;
use App\Models\Podcast;
use Brideo\IbmWatson\Ibm\ConceptInsights\Corpus;
use Brideo\IbmWatson\Ibm\Config;
use Brideo\IbmWatson\Ibm\Factory\ConceptInsights\CorpusFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PodcastController extends Controller
{

    /**
     * @var Corpus;
     */
    protected $corpus;

    public function view($id, $slug) {

        /** @var Podcast $podcast */
        $podcast = Podcast::findOrFail($id);

        if ($podcast) {
            if ($podcast->getSlug() != $slug) {
                return redirect(route('podcast.view', ['id' => $podcast->getId(), 'slug' => $podcast->getSlug()]));
            }

            return view('podcast.view', ['podcast' => $podcast]);

        }
    }


    /**
     * @return Factory|View
     */
    public function search()
    {
        return view('cms.search');
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function searchResult(Request $request)
    {
        $matches = $this->getCorpus()->getLabelSearch($request->get('search'));
        $matches = $matches->getBody()->getContents();


        return view('cms.result')->with('matches', json_decode($matches));
    }

    /**
     * @return Corpus
     */
    public function getCorpus()
    {
        if(!$this->corpus) {
            $config = new Config();
            $config->setUsername(env('IBM_CONCEPT_INSIGHTS_USERNAME'));
            $config->setPassword(env('IBM_CONCEPT_INSIGHTS_PASSWORD'));

            $this->corpus = CorpusFactory::create(ConceptInsightsCommand::CORPUS_NAME, Corpus::DEFAULT_REQUEST_METHOD, $config);
        }

        return $this->corpus;
    }
}
