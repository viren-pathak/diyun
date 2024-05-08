@extends('header')
@section('content')
<div class="home-banner">
    <h1>DIYUN</h1>
    <ul>
        @foreach($latestTags as $tag)
            <li><a href="{{ route('tags.single', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a></li>
        @endforeach
    </ul>
    <a href="{{ route('tags') }}" class="btn btn-primary">See More</a>

</div>
<div>
    <ul class="card-grid">
        @foreach($debates as $debate)
            <li>
                <div class="debate-cards">
                    <img src="{{$debate->image}}" alt="{{ $debate->title }}">
                    {{$debate->title}}
                </div>
            </li>
        @endforeach
    </ul>

</div>

@endsection