@extends('layouts.master')
@section('title')
{{ $podcast->getEpisodeName() }} - {{ $podcast->getPodcastName() }}
@stop
@section('description')
Get information on {{ $podcast->getEpisodeName() }} - {{ $podcast->getPodcastName() }}
@stop
@section('content')
    <section class="main-inner">
        <h1>{{ $podcast->getEpisodeName() }}</h1>
        <p class="podcast-name">{{ $podcast->getPodcastName() }}</p>
        <p class="podcast-published-date">{{ $podcast->getPublishedDate()->diffForHumans() }}</p>
        <a href="{{ $podcast->getUrl() }}">Download</a>

        <div class="transcription-container">
            <h2>Text Transcription</h2>
            <p class="podcast-transcription">{{ $podcast->getTranscription() }}</p>
        </div>

        <ul class="podcast-concepts">
            @foreach ($podcast->getConcepts() as $concept)
            <li>
                {{ $concept }}
            </li>
            @endforeach
        </ul>
    </section>
@stop
@section('before_body_end')
@stop
