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
        <p class="podcast-published-date">Last updated {{ $rss->getBuildDate()->diffForHumans() }}</p>
        @endif
        <a class="podcast-subscribe-link" href="{{ $rss->getUrl() }}">Subscribe</a>

        @if ($rss->getLink())
        <a class="podcast-homepage-link" href="{{ $rss->getLink() }}">Homepage</a>
        @endif

        @if ($rss->getImage())
            <img src="{{ $rss->getImage() }}" alt="{{ $rss->getName() }} Logo">
        @endif

        @if ($rss->getDescription())
        <p class="podcast-description">{{ $rss->getDescription() }}</p>
        @endif

        @if ($rss->getCategories())
            <ul class="podcast-categories">
                @foreach ($rss->getCategories() as $category)
                <li class="podcast-category">{{ $category }}</li>
                @endforeach
            </ul>
        @endif

        @if ($rss->getAuthor())
        <p class="podcast-author">{{ $rss->getAuthor() }}</p>
        @endif

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
