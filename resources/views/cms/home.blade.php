@extends('layouts.master')

@section('title', 'Home')
@section('description', 'Podcast transcription service and concept based search')

@section('content')
<section class="main-inner">
    <div class="homepage-promo">
        <p>Using IBM Watson, Poddle brings acessibility to Podcasts with transcripts, concept based search</p>

        <h2>Staff Picks</h2>
    </div>
</section>

<div class="submit-rss">
    <div class="main-inner">
        <h2>Add Podcast RSS Feed</h2>
        @include('partials/forms/rss')
    </div>
</div>

<section class="main-inner">

    <div class="latest-episodes">
        <h2>Latest Episodes</h2>
        @include('partials/lists/podcast', ['recentPodcasts' => $recentPodcasts])
    </div>

    <div class="new-rss">
        <h2>New Submissions</h2>
        @include('partials/lists/rss', ['newRss' => $newRss])
    </div>

</section>
@stop
@section('before_body_end')
@stop
