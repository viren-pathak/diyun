@extends('page.master')
@section('content')
<section class="home-banner explore-bg" style="background-image: url('{{ asset('uploads/hero-banner-bg.png') }}');">
    <div class="container">
        <h1 class="text-center explore-page__headline">Explore Debates</h1>
        <ul class="tag-flex-wrap">
            @foreach($latestTags as $tag)
                <li class="tags-btn">
                    <a href="{{ route('tags.single', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('tags') }}" class="btn tag-page-redi">See More</a>
    </div>
</section>

<section class="home-sec-1 debate-card-sec">
    <div class="container"> 
        <div class="home-debate-tabs debate-tabs">  
            <div class="row1">
                <div class="col1 debate-col">
                    <ul class="card-grid four-card-grid">
                        @foreach($debates as $debate)
                            @if($loop->index < 4)
                                <div class="debate-card">
                                    <a href="{{ route('debate.single', ['slug' => $debate->slug, 'active' => $debate->id]) }}">
                                        <div class="card-img-div">
                                            <img src="{{$debate->image}}" alt="{{ $debate->title }}">
                                        </div>
                                        <div class="card-content-body">
                                            <h5 class="debate-card-title">
                                                {{$debate->title}}
                                            </h5>
                                        </div>
                                    </a>
                                    <div class="color-text-icon d-flex align-items-center justify-content-evenly m-0">
                                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 9h8"></path><path d="M8 13h6"></path>
                                            <path d="M9 18h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-3l-3 3l-3 -3z"></path>
                                        </svg>
                                        <p class="m-0 card-text">749</p>
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path>
                                        </svg>
                                        <p class="m-0 card-text">10.9ר</p>
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M608 320h-64v64h22.4c5.3 0 9.6 3.6 9.6 8v16c0 4.4-4.3 8-9.6 8H73.6c-5.3 0-9.6-3.6-9.6-8v-16c0-4.4 4.3-8 9.6-8H96v-64H32c-17.7 0-32 14.3-32 32v96c0 17.7 14.3 32 32 32h576c17.7 0 32-14.3 32-32v-96c0-17.7-14.3-32-32-32zm-96 64V64.3c0-17.9-14.5-32.3-32.3-32.3H160.4C142.5 32 128 46.5 128 64.3V384h384zM211.2 202l25.5-25.3c4.2-4.2 11-4.2 15.2.1l41.3 41.6 95.2-94.4c4.2-4.2 11-4.2 15.2.1l25.3 25.5c4.2 4.2 4.2 11-.1 15.2L300.5 292c-4.2 4.2-11 4.2-15.2-.1l-74.1-74.7c-4.3-4.2-4.2-11 0-15.2z"></path>
                                        </svg>
                                        <p class="m-0 card-text">6.2ר</p>
                                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                        </svg>
                                        <p class="m-0 card-text">1ר</p>
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                        </svg>
                                        <p class="m-0 card-text">62.6ר</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="col2 data-col global-statistics-col">
                    <div class="statistics-card global-statistics-card">
                        <div class="statistics-card__header">
                            <img class="icon icon--global-stats" src="{{ asset('uploads/progress-bar.png')}}" alt="progress-bar"/>
                            <div class="statistics-card__title">
                                <span class="bold-text">Diyun in Numbers</span>
                                <span class="light-text">(Public Debates)</span>
                            </div>
                        </div>

                        <div class="statistics-card__body">
                            <div class="global-statistics-card__item-container">
                                <div class="statistics-title">
                                    <img class="icon icon--global-stats" src="{{ asset('uploads/total-contributions.png')}}" alt="logo"/>
                                    <p class="global-statistics-item__header-label">Total Contributions</p> 
                                </div>
                                <p class="global-statistics-item__count">{{ $sumData['total_contributions'] }}</p>
                            </div>
                            <hr>
                            <div class="global-statistics-card__item-container">
                                <div class="statistics-title">
                                    <img class="icon icon--global-stats" src="{{ asset('uploads/total-votes.png')}}" alt="logo"/>
                                    <p class="global-statistics-item__header-label">Total Votes</p> 
                                </div>
                                <p class="global-statistics-item__count">{{ $sumData['total_votes'] }}</p>
                            </div>
                            <hr>
                            <div class="global-statistics-card__item-container">
                                <div class="statistics-title">
                                    <img class="icon icon--global-stats" src="{{ asset('uploads/total-debates.png')}}" alt="logo"/>
                                    <p class="global-statistics-item__header-label">Total Debates</p>
                                </div> 
                                <p class="global-statistics-item__count">{{ $sumData['debate_count'] }}</p>
                            </div>
                            <hr>
                            <div class="global-statistics-card__item-container">
                                <div class="statistics-title">
                                    <img class="icon icon--global-stats" src="{{ asset('uploads/total-claims.png')}}" alt="logo"/>
                                    <p class="global-statistics-item__header-label">Total Claims</p> 
                                </div>
                                <p class="global-statistics-item__count">{{ $sumData['total_claims'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="top-contributors-card global-statistics-card">
                        <div class="statistics-card__header">
                            <img class="icon icon--global-stats" src="{{ asset('uploads/progress-bar.png')}}" alt="progress-bar"/>
                            <div class="statistics-card__title">
                                <span class="bold-text">Top Contributors</span>
                                <span class="light-text">(7d / Public Debates)</span>
                            </div>
                        </div>

                        <div class="statistics-card__body">
                            @foreach($topContributors->chunk(5) as $chunk)
                                <div class="top-contri-slide">
                                    @foreach($chunk as $index => $user)
                                        <div class="contributor contributor-item">
                                            <div class="contributor-index">{{ $index + 1 }}</div>
                                            <img src="{{ $user->profile_picture }}" alt="{{ $user->username }}" class="avatar">
                                            <div class="contributor-item__name-and-subtitle">
                                                <p class="contributor-name">{{ $user->username }}</p>
                                                <p class="contributor-subtitle">{{ $user->total_contributions }} Contributions</p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row2">
                <div class="debate-col">
                        <ul class="card-grid">
                            @foreach($debates as $debate)
                                @if($loop->index >= 4)
                                    <div class="debate-card">
                                        <a href="{{ route('debate.single', ['slug' => $debate->slug, 'active' => $debate->id]) }}">
                                            <div class="card-img-div">
                                                <img src="{{$debate->image}}" alt="{{ $debate->title }}">
                                            </div>
                                            <div class="card-content-body">
                                                <h5 class="debate-card-title">
                                                    {{$debate->title}}
                                                </h5>
                                            </div>
                                        </a>
                                        <div class="color-text-icon d-flex align-items-center justify-content-evenly m-0">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 9h8"></path><path d="M8 13h6"></path>
                                                <path d="M9 18h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-3l-3 3l-3 -3z"></path>
                                            </svg>
                                            <p class="m-0 card-text">749</p>
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path>
                                            </svg>
                                            <p class="m-0 card-text">10.9ר</p>
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M608 320h-64v64h22.4c5.3 0 9.6 3.6 9.6 8v16c0 4.4-4.3 8-9.6 8H73.6c-5.3 0-9.6-3.6-9.6-8v-16c0-4.4 4.3-8 9.6-8H96v-64H32c-17.7 0-32 14.3-32 32v96c0 17.7 14.3 32 32 32h576c17.7 0 32-14.3 32-32v-96c0-17.7-14.3-32-32-32zm-96 64V64.3c0-17.9-14.5-32.3-32.3-32.3H160.4C142.5 32 128 46.5 128 64.3V384h384zM211.2 202l25.5-25.3c4.2-4.2 11-4.2 15.2.1l41.3 41.6 95.2-94.4c4.2-4.2 11-4.2 15.2.1l25.3 25.5c4.2 4.2 4.2 11-.1 15.2L300.5 292c-4.2 4.2-11 4.2-15.2-.1l-74.1-74.7c-4.3-4.2-4.2-11 0-15.2z"></path>
                                            </svg>
                                            <p class="m-0 card-text">6.2ר</p>
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                            </svg>
                                            <p class="m-0 card-text">1ר</p>
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                            </svg>
                                            <p class="m-0 card-text">62.6ר</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection