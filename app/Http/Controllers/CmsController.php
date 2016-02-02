<?php namespace App\Http\Controllers;

class CmsController extends Controller
{

	/**
	 * Show Home Screen
	 *
	 * @return Response
	 */
	public function home()
	{
		return view('cms.home');
	}
}
