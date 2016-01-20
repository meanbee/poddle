<?php

namespace App\Http\Controllers;

class PodcastController extends Controller
{

    /**
     * Show the submit article page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSubmit()
    {
        return view('podcast.submit');
    }
}
