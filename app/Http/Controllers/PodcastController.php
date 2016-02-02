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

    /**
     * Show the submit article page.
     *
     * @return Factory|View
     */
    public function getSubmit()
    {
        return view('podcast.submit');
    }

    /**
     *
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postSubmit(Request $request)
    {
        Podcast::create($request->all());

        return redirect('podcast/submit');
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
