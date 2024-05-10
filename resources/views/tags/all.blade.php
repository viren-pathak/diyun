@extends('page.master')

@section('content')
<section class="explore-bg tags-page-banner" style="background-image: url('{{ asset('uploads/hero-banner-bg.png') }}');">
    <div class="container">
        <h2 class="text-center explore-page__headline">Explore Tags</h2>
    </div>
</section>
<section>
    <div class="container"> 
        <div class="tag-overview-page__content">
            <ul class="tag-card-grid mt-5 p-0  responsive-grid">
                @foreach($tags as $tag)
                    <li class="tag-card-glob" style="background-image: url('{{ asset('storage/' . $tag->tag_image) }}');">
                        <a class="tag-card" href="{{ route('tags.single', ['tag' => $tag->tag]) }}">
                            <h4 class="fw-bold">{{ $tag->tag }}</h4>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
@endsection
