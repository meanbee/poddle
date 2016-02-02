@extends('layouts.master')

@section('title', 'Add Podcast')
@section('description', 'Submit your podcast to our index')

@section('content')
    <section class="main-inner">
        <div class="homepage-promo">
            <h1>Add Podcast</h1>

            @include('partials/forms/podcast')
        </div>
    </section>
@stop
@section('before_body_end')
@stop
