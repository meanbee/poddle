@extends('layouts.master')

@section('title', 'Home')
@section('description', 'Podcast transcript service and indexing service')

@section('content')
<section class="main-inner">
    <div class="homepage-promo">
        <p>Bringing accessibility to Podcasts with transcripts, concept summary and search indexing</p>

        <h1>Add Podcast RSS Feed</h1>
        @include('partials/forms/rss')
    </div>
</section>
@stop
@section('before_body_end')
@stop
