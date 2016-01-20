<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{

    /**
     * Show the submit article page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
}
