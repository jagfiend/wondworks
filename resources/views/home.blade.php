@extends('layouts.application')

@include('layouts.header')

@section('content')
    <p>I am Pete Wond, a web developer. I build things and I write about building things here on WondWorks.</p>

    @if($posts->isEmpty())
        <p>-- There are currently no posts to display --</p>
    @else
        <ul>
            @foreach($posts as $post)
                <li>
                    <a href="{{ route('posts.show', $post) }}">{{ $post->display_date_published }} - {{ $post->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
