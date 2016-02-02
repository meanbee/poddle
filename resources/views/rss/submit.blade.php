@extends('layouts.master')

@section('title', 'Add Podcast')
@section('description', 'Submit your podcast to our index')

@section('content')
    <section class="main-inner">
        <div class="homepage-promo">
            <h1>Add Podcast RSS</h1>

            @include('partials/forms/rss')
        </div>
    </section>
@stop
@section('before_body_end')
@stop
