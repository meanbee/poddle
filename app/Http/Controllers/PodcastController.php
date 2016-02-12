<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Services\Podcasts\Search;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PodcastController extends Controller
{

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
        $matches = (new Search($request->get('search'), false))->search();

        return view('cms.result')->with('matches', $matches);
    }

}
