@extends('page.master')

@section('content')
<section class="debate-single-content">
    <div class="container">

        <div class="content__sunburst-mini-map">
        </div>

        <div class="content__body-container">
            <div class="content__body">
                <div class="ancestor-stack">
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
                            <div class="column-box column-box--pro">
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
                                <div class="pros">
                                    @foreach($pros as $pro)
                                        <div class="pro-argument">
                                            {{ $pro->title }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="column-box column-box--con">
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
                                <div class="cons">
                                    @foreach($cons as $con)
                                        <div class="con-argument">
                                            {{ $con->title }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="columns-container__column-contents">

                        </div>
                    </div>

                </main>
            </div>
        </div>
    </div>
</section>

@endsection
