@extends('layouts.application')

@include('layouts.header')

@section('content')
    <h2 class="post-title">{{ $post->title }}</h2>
    <div>{{ $post->display_date_published }}</div>
    <div>{!! $post->display_content !!}</div>
@endsection
