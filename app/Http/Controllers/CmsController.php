<?php namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\Rss;

class CmsController extends Controller
{

	/**
	 * Show Home Screen
	 *
	 * @return Response
	 */
	public function home()
	{
		$recentPodcasts = Podcast::getRecent();
		$newRss = Rss::getNew();

		return view(
			'cms.home',
			['recentPodcasts' => $recentPodcasts, 'newRss' => $newRss]
		);
	}
}
