@extends('layouts.master')

@section('title', 'Results')
@section('description', 'Podcast transcript service and indexing service')

@section('content')
    <section class="main-inner">
        <h2>Search Results:</h2>
        @include('partials/lists/podcast', ['recentPodcasts' => $matches])
    </section>
@stop
@section('before_body_end')
@stop
