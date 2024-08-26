@extends('layouts.application')

@include('layouts.header')

@section('content')
    <style>
        .post-title {
            margin-top: 0;
        }
    </style>
    
    <h2 class="post-title">{{ $post->title }}</h2>
    <p>{{ $post->display_date_published }}</p>
    <div>{!! $post->display_content !!}</div>
@endsection
