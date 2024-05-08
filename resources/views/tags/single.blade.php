<!-- Single tag page -->
@extends('page.master')
@section('content')
    <h1>Debates related to {{ $tag->tag }}</h1>
    <p>{{ $tag->tag_description }}</p>
    @foreach($debates as $debate)
        <li>
            <div class="debate-cards">
                <img src="{{$debate->image}}" alt="{{ $debate->title }}">
                {{$debate->title}}
            </div>
        </li>
    @endforeach
@endsection