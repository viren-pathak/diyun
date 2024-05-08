@extends('page.master')

@section('content')
    <h1>Explore Tags</h1>
    <ul>
        @foreach($tags as $tag)
            <li><a href="{{ route('tags.single', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a></li>
        @endforeach
    </ul>
@endsection
