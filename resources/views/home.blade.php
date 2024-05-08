@extends('header')
@section('content')
<div class="home-banner">
    <h1>DIYUN</h1>
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