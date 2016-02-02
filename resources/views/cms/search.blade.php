@extends('layouts.master')

@section('title', 'Search page')
@section('description', 'Podcast transcript service and indexing service')

@section('content')
<section class="main-inner">
    <div class="homepage-promo">
        <p>Search for a topic of podcast using our index.</p>

        @include('podcast/search')
    </div>
</section>
@stop
@section('before_body_end')
@stop
