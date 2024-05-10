<!-- Single tag page -->
@extends('page.master')
@section('content')
<section class="tag-single-banner text-center" style="background-image: url('{{ asset('storage/' . $tag->tag_image) }}');">
    <div class="container">
        <h1>Debates related to #{{ $tag->tag }}</h1>
        <p>{{ $tag->tag_description }}</p>
    </div>
</section>
    @foreach($debates as $debate)
        <li>
            <div class="debate-cards">
                <img src="{{$debate->image}}" alt="{{ $debate->title }}">
                {{$debate->title}}
            </div>
        </li>
    @endforeach
@endsection