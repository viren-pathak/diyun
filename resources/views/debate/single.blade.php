@extends('page.master')

@section('content')
<section class="debate-single-content">
    <div class="container">

        <div class="content__sunburst-mini-map">
        </div>

        <div class="content__body-container">
            <div class="content__body">
                <div class="ancestor-stack">
                    <div class="ancestor-claim-container">
                        <div class="ancestor-claim">
                            <div class="claim-card">
                                <div class="claim-header">
                                </div>

                                <div class="claim-text">
                                    <h2 class="claim-text__content">{{ $debate->thesis }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <main class="content__selected-and-columns">
                    <div class="selected-claim-container">
                        <div class="selected-claim">
                            <div class="claim-card">
                                <div class="claim-header">
                                </div>

                                <div class="claim-text">
                                    <h2 class="claim-text__content">{{ $debate->thesis }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns-container">
                        <div class="columns-container__column-headers">
                            <div class="column-box column-box--header--pro">
                                <p class="column-box--pro--info">Pros</p>
                                <button type="button" class="btn-danger btn add-pro-btn" data-authenticated="{{ auth()->check() }}">+</button>
                                <div class="add-pro-form" style="display:none;">
                                    <form action="{{ route('debate.addPro', $debate->id) }}" method="POST">
                                        @csrf
                                        <input type="text" name="title" placeholder="Enter pro argument" maxlength="500">
                                        <p class="char-count">500 characters remaining</p>
                                        <button type="submit">Submit</button>
                                        <button type="button" class="close-form-btn">Close</button>
                                    </form>
                                </div>
                            </div>

                            <div class="column-box column-box--header--con">
                                <p class="column-box--con--info">Cons</p>
                                <button type="button" class="btn-danger btn add-cons-btn" data-authenticated="{{ auth()->check() }}">+</button>
                                <div class="add-con-form" style="display:none;">
                                    <form action="{{ route('debate.addCon', $debate->id) }}" method="POST">
                                        @csrf
                                        <input type="text" name="title" placeholder="Enter con argument" maxlength="500">
                                        <p class="char-count">500 characters remaining</p>
                                        <button type="submit">Submit</button>
                                        <button type="button" class="close-form-btn">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="columns-container__column-contents">
                            <div class="column-box column-box--claims column-box--claims-pro">
                                <ul class="column__content--pros">
                                    @foreach($pros as $pro)
                                        <li class="pro-argument">
                                            <div class="actionable-claim-container">
                                                <div class="actionable-claim">
                                                    <div class="claim-card child-claim-card">
                                                        <div class="claim-header">
                                                        </div>

                                                        <div class="claim-text">
                                                            <p class="claim-text__content">{{ $pro->title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="column-box column-box--claims column-box--claims-con">
                                <ul class="column__content--cons">
                                    @foreach($cons as $con)
                                        <li class="con-argument">
                                            <div class="actionable-claim-container">
                                                <div class="actionable-claim">
                                                    <div class="claim-card child-claim-card">
                                                        <div class="claim-header">
                                                        </div>

                                                        <div class="claim-text">
                                                            <p class="claim-text__content">{{ $con->title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </div>
</section>

@endsection
