<?php

namespace App\Http\Controllers;

use App\Models\Rss;
use Illuminate\Http\Request;

class RssController extends Controller
{

    public function view($id, $slug) {

        /** @var Rss $rss */
        $rss = Rss::findOrFail($id);

        if ($rss) {
            if ($rss->getSlug() != $slug) {
                return redirect(route('rss.view', ['id' => $rss->getId(), 'slug' => $rss->getSlug()]));
            }

            return view('rss.view', ['rss' => $rss]);

        }
    }

    /**
     * Show the submit article page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSubmit()
    {
        return view('rss.submit');
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

        $exists = Rss::where(RSS::COLUMN_URL, '=', $request->get(RSS::COLUMN_URL))->count();

        if (!$exists) {
            $rss = Rss::create($request->all());

            if ($rss) {
                $request->session()->flash('success', 'Rss added!');
            } else {
                $request->session()->flash('error', 'Something went wrong');
            }
        } else {
            $request->session()->flash('error', 'We already know about this feed, thanks.');
        }

        return redirect('rss/submit');
    }
}
