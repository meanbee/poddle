@extends('layouts.master')

@section('title', 'Results')
@section('description', 'Podcast transcript service and indexing service')

@section('content')
    <section class="main-inner">
        @foreach($matches as $match)
            output match.
        @endforeach
    </section>
@stop
@section('before_body_end')
@stop
