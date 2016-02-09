@extends('layouts.master')

@section('title', 'Home')
@section('description', 'Podcast transcript service and indexing service')

@section('content')
<section class="main-inner">
    <div class="homepage-promo">
        <p>Bringing accessibility to Podcasts with transcripts, concept summary and search indexing</p>

        <div class="latest-episodes">
            <h2>Latest Episodes</h2>
            @include('partials/lists/podcast', ['recentPodcasts' => $recentPodcasts])
        </div>

        <div class="new-rss">
            <h2>New Submissions</h2>
            @include('partials/lists/rss', ['newRss' => $newRss])
        </div>

        <div class="submit-rss">
            <h2>Add Podcast RSS Feed</h2>
            @include('partials/forms/rss')
        </div>
    </div>
</section>
@stop
@section('before_body_end')
@stop
