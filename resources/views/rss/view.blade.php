@extends('layouts.master')
@section('title')
    {{ $rss->getName() }}
@stop
@section('description')
    Get information on {{ $rss->getName() }}
@stop
@section('content')
    <section class="main-inner">
        <h1>{{ $rss->getName() }}</h1>
        @if ($rss->getBuildDate())
        <p class="podcast-published-date">{{ $rss->getBuildDate()->diffForHumans() }}</p>
        @endif
        <a href="{{ $rss->getUrl() }}">Subscribe</a>

        @if ($rss->recentPodcasts())
        <div class="podcast-episodes-list-container">
            <h2>Recent Episodes</h2>
            @include('partials/lists/podcast', ['recentPodcasts' => $rss->recentPodcasts()->get()])
        </div>
        @else
            <p>No episodes found for this feed yet. If not episodes are found upon sync, then this feed will be deleted.</p>
        @endif
    </section>
@stop
@section('before_body_end')
@stop
