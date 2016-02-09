<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', ['as' => 'cms.home', 'uses' => 'CmsController@home']);

    Route::get('/rss/submit', ['as' => 'rss.submit', 'uses' => 'RssController@getSubmit']);
    Route::post('/rss/submit', ['as' => 'rss.submit', 'uses' => 'RssController@postSubmit']);

    Route::post('/search/result', ['as' => 'podcast.search.result', 'uses' => 'PodcastController@searchResult']);
});
