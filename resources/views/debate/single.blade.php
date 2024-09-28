@extends('debate.master')
@include('debate.info-popup', ['debate' => $debate])
@section('content')

<section class="debate-single-content">
    <div class="container">

        <div class="debate-single-content__header">
            <div class="content-header__icons content-header__icons--left">
                <button class="info-popup-icon" onclick="openInfoPopup()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                </button>
                <button class="archive-visibility-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                    </svg>
                </button>
            </div>

            <div class="content-header__icons content-header__icons--center">
                <button class="sunburst-icon">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8.848 14.667l-3.348 2.833"></path>
                        <path d="M12 3v5m4 4h5"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M14.219 15.328l2.781 4.172"></path>
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                    </svg>
                </button>

                <button class="tree-chart-icon">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.25 12h-0.25v-3.25c0-0.965-0.785-1.75-1.75-1.75h-4.25v-2h0.25c0.412 0 0.75-0.338 0.75-0.75v-2.5c0-0.413-0.338-0.75-0.75-0.75h-2.5c-0.412 0-0.75 0.337-0.75 0.75v2.5c0 0.412 0.338 0.75 0.75 0.75h0.25v2h-4.25c-0.965 0-1.75 0.785-1.75 1.75v3.25h-0.25c-0.412 0-0.75 0.338-0.75 0.75v2.5c0 0.412 0.338 0.75 0.75 0.75h2.5c0.413 0 0.75-0.338 0.75-0.75v-2.5c0-0.412-0.337-0.75-0.75-0.75h-0.25v-3h4v3h-0.25c-0.412 0-0.75 0.338-0.75 0.75v2.5c0 0.412 0.338 0.75 0.75 0.75h2.5c0.412 0 0.75-0.338 0.75-0.75v-2.5c0-0.412-0.338-0.75-0.75-0.75h-0.25v-3h4v3h-0.25c-0.412 0-0.75 0.338-0.75 0.75v2.5c0 0.412 0.338 0.75 0.75 0.75h2.5c0.412 0 0.75-0.338 0.75-0.75v-2.5c0-0.412-0.338-0.75-0.75-0.75zM3 15h-2v-2h2v2zM9 15h-2v-2h2v2zM7 4v-2h2v2h-2zM15 15h-2v-2h2v2z"></path>
                    </svg>
                </button>
            </div>


            <div class="content-header__icons content-header__icons--right">
            </div>

        </div>

        <div class="content__body-container">

            <div class="content__sunburst-mini-map">
            </div>

            <div class="content__body">
                <div class="ancestor-stack">
                    <div class="ancestor-cards">
                        @foreach($ancestors as $ancestor)
                            <div class="ancestor-claim claims {{ $ancestor->side ? $ancestor->side . '-child-claim' : 'root-debate-claim' }}">
                                <div class="claim-card" data-debate-id="{{ $ancestor->id }}" data-debate-slug="{{ $ancestor->slug }}">
                                    <div class="claim-header">
                                        <div class="votes-btn-container">
                                            {{-- PRGRESS BAR BLADE in views>components>progress-bar.blade.php --}}
                                            <x-progress-bar :value="$averageVotes['ancestors'][$ancestor->id]" />

                                            {{-- Total Votes Progress Bar --}}
                                            @php
                                                $totalVotes = $getTotalVotes($ancestor->id);
                                                $totalVotesValue = min($totalVotes * 10, 100);
                                            @endphp
                                            @if($totalVotes > 0)
                                            <div class="total-votes-bar">
                                                <div class="total-votes" style="width: {{ $totalVotesValue }}%;"></div>
                                            </div>
                                            @endif

                                            <button class="votes-btn" data-target="votesContainerAncestor{{ $ancestor->id }}">Votes</button>
                                        </div>
                                        @if(auth()->check())
                                            <div class="thanks-btn-container">
                                                <button class="thanks-btn">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="control-item-btn-container">
                                            <button class="control-item-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="comments-btn-conaitner">
                                            <button class="comment-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-fill" viewBox="0 0 16 16">
                                                    <path d="M2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                </svg>
                                                <span class="comment-count">{{ $ancestor->comments->count() > 0 ? $ancestor->comments->count() : '' }}</span>
                                            </button>
                                        </div>
                                        @if(auth()->check() && auth()->user()->id === $ancestor->user_id)
                                            <div class="edit-btn-container" onclick="openEditModal('{{ $ancestor->title }}', '{{ $ancestor->id }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        @auth
                                            @if(!$ancestor->isReadBy(Auth::user()->id))  {{-- Only show the button if the user hasn't marked it as read --}}
                                                <div class="unread-indicator">
                                                    <button class="mark-as-read-btn unread-indicator__button" data-debate-id="{{ $ancestor->id }}">
                                                        <span class="unread-indicator__core"></span>
                                                    </button>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>
                                    <div class="claim-text">
                                        <p class="claim-text__content" data-debate-id="{{ $ancestor->id }}">{{ $ancestor->title }}</p>
                                    </div>
                                </div>
                                
                                <div id="detail-drawer-container"></div>

                                @include('debate.ancestors-vote')
                            </div>
                        @endforeach
                    </div>

                </div>

                <main class="content__selected-and-columns">
                    <div class="selected-claim-container">
                        <div class="selected-claim claims {{ $debate->side ? $debate->side . '-child-claim' : 'root-debate-claim' }}">
                            <div class="claim-card" data-debate-id="{{ $debate->id }}" data-debate-slug="{{ $debate->slug }}">
                                <div class="claim-header">
                                    <div class="votes-btn-container">
                                        {{-- PRGRESS BAR BLADE in views>components>progress-bar.blade.php --}}
                                        <x-progress-bar :value="$averageVotes['debate']" />

                                        {{-- Total Votes Progress Bar --}}
                                        @php
                                            $totalVotes = $getTotalVotes($debate->id);
                                            $totalVotesValue = min($totalVotes * 10, 100);
                                        @endphp
                                        @if($totalVotes > 0)
                                        <div class="total-votes-bar">
                                            <div class="total-votes" style="width: {{ $totalVotesValue }}%;"></div>
                                        </div>
                                        @endif

                                        <button class="votes-btn" data-target="votesContainer{{ $debate->id }}">Votes</button>
                                    </div>
                                    @if(auth()->check())
                                        <div class="thanks-btn-container">
                                            <button class="thanks-btn">
                                                <i class="fa fa-heart-o" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    @endif
                                    <div class="control-item-btn-container">
                                        <button class="control-item-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                            </svg>
                                        </button>
                                    </div>
                                    @if(auth()->check() && auth()->user()->id === $debate->user_id)
                                        <div class="edit-btn-container" onclick="openEditModal('{{ $debate->title }}', '{{ $debate->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="comments-btn-conaitner">
                                        <button class="comment-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-fill" viewBox="0 0 16 16">
                                                <path d="M2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                            </svg>
                                            <span class="comment-count">{{ $debate->comments->count() > 0 ? $debate->comments->count() : '' }}</span>
                                        </button>
                                    </div>
                                    @auth
                                        @if(!$debate->isReadBy(Auth::user()->id))  {{-- Only show the button if the user hasn't marked it as read --}}
                                            <div class="unread-indicator">
                                                <button class="mark-as-read-btn unread-indicator__button" data-debate-id="{{ $debate->id }}">
                                                    <span class="unread-indicator__core"></span>
                                                </button>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                                <div class="claim-text">
                                    <p class="claim-text__content" data-debate-id="{{ $debate->id }}">{{ $debate->title }}</p>
                                </div>
                            </div>

                            <div id="detail-drawer-container"></div>

                            @include('debate.selected-vote')

                        </div>
                    </div>
                    
                    <div class="columns-container">
                        <div class="columns-container__column-headers">
                            <div class="column-box column-box--header--pro">
                                <div class="column-box--header--pro--contents">
                                    <p class="column-box--pro--info">Pros</p>
                                    <button type="button" class="btn-danger btn add-pro-btn" data-authenticated="{{ auth()->check() }}">+</button>
                                </div>                                
                            </div>
                            <div class="column-box column-box--header--con">
                                <div class="column-box--header--con--contents">
                                    <p class="column-box--con--info">Cons</p>
                                    <button type="button" class="btn-danger btn add-cons-btn" data-authenticated="{{ auth()->check() }}">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="columns-container__column-contents">
                            <div class="column-box column-box--claims column-box--claims-pro">
                                <ul class="column__content--pros">
                                    <li class="new-claim-editor new-pro-claim">
                                        <div class="add-pro-form-container add-child-form-container" style="display:none;">
                                            <form action="{{ route('debate.addPro', $debate->id) }}" method="POST" class="add-pro-form">
                                                @csrf
                                                <input class="child-form-input" type="text" name="title" placeholder="Enter pro argument" maxlength="500">
                                                <p class="char-count">500 characters remaining</p>
                                                <button class="child-form-submit" type="submit">Submit</button>
                                                <button type="button" class="close-form-btn">Close</button>
                                            </form>
                                        </div>
                                    </li>                                      
                                    @foreach($pros as $pro)
                                        <li class="pro-argument">
                                            <div class="actionable-claim-container">
                                                <div class="actionable-claim claims {{ $pro->side }}-child-claim">
                                                    <div class="claim-card child-claim-card" data-debate-id="{{ $pro->id }}" data-debate-slug="{{ $pro->slug }}">
                                                        <div class="claim-header">
                                                            <div class="votes-btn-container">
                                                                {{-- PRGRESS BAR BLADE in views>components>progress-bar.blade.php --}}
                                                                <x-progress-bar :value="$averageVotes['pros'][$pro->id]" />

                                                                {{-- Total Votes Progress Bar --}}
                                                                @php
                                                                    $totalVotes = $getTotalVotes($pro->id);
                                                                    $totalVotesValue = min($totalVotes * 10, 100);
                                                                @endphp
                                                                @if($totalVotes > 0)
                                                                <div class="total-votes-bar">
                                                                    <div class="total-votes" style="width: {{ $totalVotesValue }}%;"></div>
                                                                </div>
                                                                @endif

                                                                <button class="votes-btn" data-target="votesContainerPro{{ $pro->id }}">Votes</button>
                                                            </div>
                                                            @if(auth()->check())
                                                                <div class="thanks-btn-container">
                                                                    <button class="thanks-btn">
                                                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            @endif
                                                            <div class="control-item-btn-container">
                                                                <button class="control-item-btn">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="comments-btn-conaitner">
                                                                <button class="comment-btn">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-fill" viewBox="0 0 16 16">
                                                                        <path d="M2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                                    </svg>
                                                                    <span class="comment-count">{{ $pro->comments->count() > 0 ? $pro->comments->count() : '' }}</span>
                                                                </button>
                                                            </div>
                                                            @if(auth()->check() && auth()->user()->id === $pro->user_id)
                                                                <div class="edit-btn-container" onclick="openEditModal('{{ $pro->title }}', '{{ $pro->id }}')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            @auth
                                                                @if(!$pro->isReadBy(Auth::user()->id))  {{-- Only show the button if the user hasn't marked it as read --}}
                                                                    <div class="unread-indicator">
                                                                        <button class="mark-as-read-btn unread-indicator__button" data-debate-id="{{ $pro->id }}">
                                                                            <span class="unread-indicator__core"></span>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            @endauth
                                                        </div>
                                                        <div class="claim-text">
                                                            <p class="claim-text__content" data-debate-id="{{ $pro->id }}">{{ $pro->title }}</p>
                                                        </div>
                                                        @if (!$pro->buttonFlags['hideActionButtons'])
                                                            <div class="claim-button-bar">
                                                                @if ($pro->buttonFlags['isChildCreator'])
                                                                    <div class="claim-button-bar__child-creator">
                                                                        <button class="claim-button-bar__archive button-bar__child">Archive</button>
                                                                        <button class="claim-button-bar__move button-bar__child">Move</button>
                                                                        <button class="claim-button-bar__edit button-bar__child">Edit</button>
                                                                    </div>
                                                                @endif

                                                                @if ($pro->buttonFlags['isRootOwner'])
                                                                    <div class="claim-button-bar__root-owner">
                                                                    <button class="claim-button-bar__reply button-bar__owner">Reply</button>
                                                                    <button class="claim-button-bar__accept button-bar__owner">Accept</button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div id="detail-drawer-container"></div>
                                                    
                                                    @include('debate.pros-vote')
                                                </div>
                                                @if($pro->hasChildren)
                                                    <div class="children-indicator">
                                                        <div class="children-indicator__child"></div>
                                                        <div class="children-indicator__shadow"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="column-box column-box--claims column-box--claims-con">
                                <ul class="column__content--cons">
                                    <li class="new-claim-editor new-con-claim">
                                        <div class="add-con-form-container add-child-form-container" style="display:none;">
                                            <form action="{{ route('debate.addCon', $debate->id) }}" method="POST" class="add-con-form">
                                                @csrf
                                                <input class="child-form-input" type="text" name="title" placeholder="Enter con argument" maxlength="500">
                                                <p class="char-count">500 characters remaining</p>
                                                <button class="child-form-submit" type="submit">Submit</button>
                                                <button type="button" class="close-form-btn">Close</button>
                                            </form>
                                        </div>
                                    </li>
                                    @foreach($cons as $con)
                                        <li class="con-argument">
                                            <div class="actionable-claim-container">
                                                <div class="actionable-claim claims {{ $con->side }}-child-claim">
                                                    <div class="claim-card child-claim-card" data-debate-id="{{ $con->id }}" data-debate-slug="{{ $con->slug }}">
                                                        <div class="claim-header">
                                                            <div class="votes-btn-container">
                                                                {{-- PRGRESS BAR BLADE in views>components>progress-bar.blade.php --}}
                                                                <x-progress-bar :value="$averageVotes['cons'][$con->id]" />

                                                                {{-- Total Votes Progress Bar --}}
                                                                @php
                                                                    $totalVotes = $getTotalVotes($con->id);
                                                                    $totalVotesValue = min($totalVotes * 10, 100);
                                                                @endphp
                                                                @if($totalVotes > 0)
                                                                <div class="total-votes-bar">
                                                                    <div class="total-votes" style="width: {{ $totalVotesValue }}%;"></div>
                                                                </div>
                                                                @endif

                                                                <button class="votes-btn" data-target="votesContainerCon{{ $con->id }}">Votes</button>
                                                            </div>
                                                            @if(auth()->check())
                                                                <div class="thanks-btn-container">
                                                                    <button class="thanks-btn">
                                                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            @endif
                                                            <div class="control-item-btn-container">
                                                                <button class="control-item-btn">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="comments-btn-conaitner">
                                                                <button class="comment-btn">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-fill" viewBox="0 0 16 16">
                                                                        <path d="M2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                                                    </svg>
                                                                    <span class="comment-count">{{ $con->comments->count() > 0 ? $con->comments->count() : '' }}</span>
                                                                </button>
                                                            </div>
                                                            @if(auth()->check() && auth()->user()->id === $con->user_id)
                                                                <div class="edit-btn-container" onclick="openEditModal('{{ $con->title }}', '{{ $con->id }}')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            @auth
                                                                @if(!$con->isReadBy(Auth::user()->id))  {{-- Only show the button if the user hasn't marked it as read --}}
                                                                    <div class="unread-indicator">
                                                                        <button class="mark-as-read-btn unread-indicator__button" data-debate-id="{{ $con->id }}">
                                                                            <span class="unread-indicator__core"></span>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            @endauth
                                                        </div>
                                                        <div class="claim-text">
                                                            <p class="claim-text__content" data-debate-id="{{ $con->id }}">{{ $con->title }}</p>
                                                        </div>
                                                        @if (!$con->buttonFlags['hideActionButtons'])
                                                            <div class="claim-button-bar">
                                                                @if ($con->buttonFlags['isChildCreator'])
                                                                    <div class="claim-button-bar__child-creator">
                                                                        <button class="claim-button-bar__archive button-bar__child">Archive</button>
                                                                        <button class="claim-button-bar__move button-bar__child">Move</button>
                                                                        <button class="claim-button-bar__edit button-bar__child">Edit</button>
                                                                    </div>
                                                                @endif

                                                                @if ($con->buttonFlags['isRootOwner'])
                                                                    <div class="claim-button-bar__root-owner">
                                                                    <button class="claim-button-bar__reply button-bar__owner">Reply</button>
                                                                    <button class="claim-button-bar__accept button-bar__owner">Accept</button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div id="detail-drawer-container"></div>

                                                    @include('debate.cons-vote')
                                                </div>
                                                @if($con->hasChildren)
                                                    <div class="children-indicator">
                                                        <div class="children-indicator__child"></div>
                                                        <div class="children-indicator__shadow"></div>
                                                    </div>
                                                @endif
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to check if user is authenticated
        function authCheck() {
            return button.getAttribute('data-authenticated') === '1';
        }

        // Function to handle the selection of a claim
        function selectClaim(claimId, claimSlug) {
            // Clear the current selection
            clearSelection();

            // Find the selected claim card element
            const selectedClaimCard = document.querySelector(`.claim-card[data-debate-id="${claimId}"]`);

            // Update the URL with the selected claim's slug
            updateURL(claimSlug);

            // Show the selected claim card
            selectedClaimCard.classList.add('selected');

            // Find the parent claim container
            const claimContainer = selectedClaimCard.closest('.claims');

            // Show the claim container
            claimContainer.classList.add('show');

            // Find and show the child claims
            showChildClaims(claimId);
        }

        // Function to clear the current selection
        function clearSelection() {
            // Remove the 'selected' class from all claim cards
            const selectedClaimCards = document.querySelectorAll('.claim-card.selected');
            selectedClaimCards.forEach(card => card.classList.remove('selected'));

            // Hide all claim containers
            const claimContainers = document.querySelectorAll('.claims.show');
            claimContainers.forEach(container => container.classList.remove('show'));

            // Hide all child claims
            const childClaimContainers = document.querySelectorAll('.child-claims.show');
            childClaimContainers.forEach(container => container.classList.remove('show'));
        }

        // Function to show the child claims of the selected claim
        function showChildClaims(claimId) {
            // Find the child claim containers for the selected claim
            const childClaimContainers = document.querySelectorAll(`.child-claims[data-parent-id="${claimId}"]`);

            // Show the child claim containers
            childClaimContainers.forEach(container => container.classList.add('show'));
        }

        // Function to update the URL with the selected claim's slug
        function updateURL(slug) {
            const newURL = `${window.location.origin}/${slug}`;
            window.history.pushState({}, '', newURL);
        }

        document.querySelectorAll('.claim-card').forEach(card => {
            card.addEventListener('click', (event) => {
                // Check if the click occurred on the claim header
                if (!event.target.closest('.claim-header') && !event.target.closest('.debate-title-modal')) {
                    const claimId = card.dataset.debateId;
                    const claimSlug = card.dataset.debateSlug;
                    const newURL = `${window.location.origin}/debate/${claimSlug}?active=${claimId}`;
                    window.location.href = newURL;
                }
            });
        });
    });

    // ##### VOTES FUNCTIONALITY

    document.addEventListener("DOMContentLoaded", function() {


        // Function to initialize the chart
        function initializeChart(canvasId, votesCount) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            var colors = [
                '#7dbbf4',
                '#4197e7',
                '#2985db',
                '#2478c6',
                '#1d67ac'
            ];

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['0', '1', '2', '3', '4'],
                    datasets: [{
                        label: 'Votes Count',
                        data: votesCount,
                        backgroundColor: colors,
                        borderColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        datalabels: {
                            color: '#000',
                            anchor: 'end',
                            align: 'end',
                            offset: -5,
                            font: {
                                weight: 'bold',
                                size: 14,
                            },
                            formatter: function(value, context) {
                                return '';  // Do not return the value here
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                        },
                        y: {
                            display: false,
                        }
                    }
                },
                plugins: [ChartDataLabels, {
                    afterDatasetsDraw: function(chart, easing) {
                        var ctx = chart.ctx;

                        chart.data.datasets.forEach(function (dataset, i) {
                            var meta = chart.getDatasetMeta(i);
                            if (!meta.hidden) {
                                meta.data.forEach(function (element, index) {
                                    // Draw the icon
                                    var fontSize = 14;
                                    var fontStyle = 'normal';
                                    var fontFamily = 'FontAwesome';
                                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                                    // Text anchor
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';

                                    var padding = -10;
                                    var position = element.tooltipPosition();
                                    ctx.fillText('\uf007', position.x - 6, position.y + padding);  // FontAwesome user icon with horizontal offset

                                    // Draw the count
                                    ctx.font = Chart.helpers.fontString(14, 'bold', 'Arial');
                                    ctx.fillText(dataset.data[index], position.x + 5, position.y + padding);  // Count with horizontal offset
                                });
                            }
                        });
                    }
                }]
            });
        }

        // Initialize charts for the main debate
        var votesCount = {!! json_encode($votesCount) !!};
        initializeChart('votesChart', votesCount);

        // Initialize charts for ancestors
        @foreach($ancestorsVotesCount as $ancestorId => $votesCount)
            initializeChart('votesChartAncestor{{ $ancestorId }}', {!! json_encode($votesCount) !!});
        @endforeach

        // Initialize charts for pros
        @foreach($prosVotesCount as $proId => $votesCount)
            initializeChart('votesChartPro{{ $proId }}', {!! json_encode($votesCount) !!});
        @endforeach

        // Initialize charts for cons
        @foreach($consVotesCount as $conId => $votesCount)
            initializeChart('votesChartCon{{ $conId }}', {!! json_encode($votesCount) !!});
        @endforeach

    });


    /// ###### EDIT DEBATE FUNCTIONALITY

    function openEditModal(currentTitle, debateId, debateSlug) {
        // Find the debate's claim-text__content element
        const claimTextContent = document.querySelector(`[data-debate-id="${debateId}"] .claim-text__content`);

        // Add the 'editing-title' class to claim-text__content element
        claimTextContent.classList.add('editing-title');

        // Create the modal HTML dynamically
        var modalHtml = `
            <div id="editModal" class="debate-title-modal">
                <div class="edit-modal-content">
                    <form id="edit-title-form">
                        @csrf
                        <label for="edit-title-input">Edit Title</label><br>
                        <input type="text" id="edit-title-input" name="title" value="${currentTitle}"><br>
                        <button type="button" class="close-btn" onclick="closeEditModal()">Close</button>
                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
        `;

        // Insert the modal HTML after the claim-text__content element
        claimTextContent.insertAdjacentHTML('afterend', modalHtml);

        // Add the event listener for the form submission
        document.getElementById('edit-title-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = event.target;
            var title = form.title.value;

            fetch(`/debate/update-title/${debateId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    title: title
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the URL if the current debate ID matches the edited one
                    const currentURL = window.location.href;
                    if (currentURL.includes(`?active=${debateId}`)) {
                        const newURL = `${window.location.origin}/debate/${data.slug}?active=${debateId}`;
                        window.location.href = newURL;
                    } else {
                        // Refresh the page to update all elements
                        location.reload();
                    }
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    function closeEditModal() {
        var modal = document.getElementById('editModal');
        if (modal) {
            const claimTextContent = modal.previousElementSibling;
            modal.parentNode.removeChild(modal);

            // Remove the 'editing-title' class from the claim-text__content element
            if (claimTextContent) {
                claimTextContent.classList.remove('editing-title');
            }
        }
    }

    /// ####### COMMENT FUNCTIONALITY

    function applyCommentFunctionality() {

         /****** EDIT COMMENT ********/

        let currentEditForm = null;

        // Function to handle comment-menu button click
        document.querySelectorAll('.comment-menu').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent hiding the comment-form-container
                const commentBox = this.closest('.comment-box');
                const commentMetaDetails = commentBox.querySelector('.comment-meta-details');

                // Hide the comment-meta-details div
                commentMetaDetails.style.display = 'none';

                // Create the comments-action div dynamically
                const commentsActionHtml = `
                    <div class="comments-action">
                        <button class="edit-comment-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                            </svg>
                        </button>
                        <button class="delete-comment-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                        </button>
                        <button class="close-comments-action-btn">Close</button>
                    </div>
                `;

                // Insert the comments-action div after the comment-meta-details div
                commentMetaDetails.insertAdjacentHTML('afterend', commentsActionHtml);

                // Add event listener to the close button to remove the comments-action div
                commentMetaDetails.nextElementSibling.querySelector('.close-comments-action-btn').addEventListener('click', function(event) {
                    event.stopPropagation(); // Stop event propagation
                    const commentsActionDiv = this.closest('.comments-action');
                    if (commentsActionDiv) {
                        commentsActionDiv.remove();
                    }
                    // Show the comment-meta-details div again
                    commentMetaDetails.style.display = 'block';
                });

                // Add event listener for edit-comment-btn 
                const editCommentBtn = commentMetaDetails.nextElementSibling.querySelector('.edit-comment-btn');
                if (editCommentBtn) {
                    editCommentBtn.addEventListener('click', handleEditComment);
                }

                // Add event listener for delete-comment-btn
                const deleteCommentBtn = commentMetaDetails.nextElementSibling.querySelector('.delete-comment-btn');
                if (deleteCommentBtn) {
                    deleteCommentBtn.addEventListener('click', handleDeleteComment);
                }
            });
        });

        // Function to handle edit comment
        function handleEditComment(event) {
            event.stopPropagation(); // Prevent hiding the comment-form-container

            // Close the currently open edit form, if any
            if (currentEditForm) {
                currentEditForm.querySelector('.edit-comment-container').remove();
                currentEditForm.querySelector('.comment-box-content').style.display = 'block';
                currentEditForm.querySelector('.comment-meta-details').style.display = 'block';
                currentEditForm = null;
            }

            const commentBox = this.closest('.comment-box');
            const commentContent = commentBox.querySelector('.comment-box-content');
            const commentText = commentContent.querySelector('.comment-content__text').innerText;

            // Create an input field and replace the comment text with it
            const editCommentHtml = `
                <div class="edit-comment-container">
                    <input type="text" class="edit-comment-input" value="${commentText}">
                    <button class="save-comment-btn">Save</button>
                    <button class="cancel-edit-comment-btn">Cancel</button>
                </div>
            `;
            commentContent.style.display = 'none';
            commentBox.insertAdjacentHTML('beforeend', editCommentHtml);

            // Close the comments-action div
            const commentsActionDiv = this.closest('.comments-action');
            if (commentsActionDiv) {
                commentsActionDiv.remove();
            }

            // Set the current edit form
            currentEditForm = commentBox;

            // Add event listener for save-comment-btn
            commentBox.querySelector('.save-comment-btn').addEventListener('click', function() {
                const newCommentText = commentBox.querySelector('.edit-comment-input').value;
                const commentId = commentBox.dataset.commentId;

                // Perform AJAX call to save the edited comment
                fetch(`/comments/edit/${commentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        comment: newCommentText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the comment text in the DOM
                        commentContent.querySelector('.comment-content__text').innerText = newCommentText;
                        commentContent.style.display = 'block';
                        commentBox.querySelector('.edit-comment-container').remove();
                        commentBox.querySelector('.comment-meta-details').style.display = 'block';

                        // Add edited text below the username
                        let editedText = commentBox.querySelector('.comment-edited');
                        if (!editedText) {
                            const commentUsername = commentBox.querySelector('.comment-username');
                            const commentTime = commentBox.querySelector('.comment-time');
                            commentUsername.insertAdjacentHTML('afterend', '<span class="comment-edited">Edited</span>');
                        }

                        // Clear the current edit form reference
                        currentEditForm = null;
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            // Add event listener for cancel-edit-comment-btn
            commentBox.querySelector('.cancel-edit-comment-btn').addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent hiding the comment-form-container
                // Remove the input field and buttons
                commentBox.querySelector('.edit-comment-container').remove();
                // Show the original comment text
                commentContent.style.display = 'block';
                // Show the comment-meta-details div again
                commentBox.querySelector('.comment-meta-details').style.display = 'block';

                // Clear the current edit form reference
                currentEditForm = null;
            });
        }



        /****** DELETE COMMENT ********/

        // Function to handle delete comment
        function handleDeleteComment(event) {
            event.stopPropagation(); // Prevent hiding the comment-form-container

            const commentBox = this.closest('.comment-box');
            openDeleteModal(commentBox);
        }

        // Function to open the delete modal
        function openDeleteModal(commentBox) {
            const deleteModalHtml = `
                <div class="delete-comment-modal">
                    <div class="modal-content">
                        <span class="close close-delete-modal">&times;</span>
                        <p>Delete this message?</p>
                        <button class="confirm-delete-btn">Delete</button>
                        <button class="cancel-delete-btn">Close</button>
                    </div>
                </div>
                <style>
                    .delete-comment-modal {
                        position: fixed;
                        z-index: 1;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: auto;
                        background-color: rgba(0,0,0,0.4);
                    }
                    .modal-content {
                        background-color: #fefefe;
                        margin: 15% auto;
                        padding: 20px;
                        border: 1px solid #888;
                        width: 80%;
                    }
                    .close.close-delete-modal {
                        color: #aaa;
                        float: right;
                        font-size: 28px;
                        font-weight: bold;
                    }
                    .close.close-delete-modal:hover,
                    .close.close-delete-modal:focus {
                        color: black;
                        text-decoration: none;
                        cursor: pointer;
                    }
                </style>
            `;

            // Append modal HTML to body
            document.body.insertAdjacentHTML('beforeend', deleteModalHtml);

            // Add event listeners to the modal buttons
            document.querySelector('.delete-comment-modal .close.close-delete-modal').addEventListener('click', function(event) {
                event.stopPropagation();
                closeDeleteModal();
            });
            document.querySelector('.delete-comment-modal .cancel-delete-btn').addEventListener('click', function(event) {
                event.stopPropagation();
                closeDeleteModal();
            });
            document.querySelector('.delete-comment-modal .confirm-delete-btn').addEventListener('click', function(event) {
                event.stopPropagation();
                deleteComment(commentBox);
            });
        }

        // Function to close the delete modal
        function closeDeleteModal() {
            const modal = document.querySelector('.delete-comment-modal');
            if (modal) {
                modal.remove();
            }
        }

        // Function to delete the comment
        function deleteComment(commentBox) {
            const commentId = commentBox.dataset.commentId;

            // Perform AJAX call to delete the comment
            fetch(`/comments/delete/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the comment from the DOM
                    commentBox.remove();
                    closeDeleteModal();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

    
    ///// ###### DEBATE CONTROL FUNCTIONALITY 
    
    document.addEventListener('DOMContentLoaded', function() {

        // Function to handle control-item button click
        document.querySelectorAll('.control-item-btn-container').forEach(container => {
            container.addEventListener('click', function(event) {
                event.stopPropagation();
                const debateCard = this.closest('.claim-card');
                const debateId = debateCard.getAttribute('data-debate-id'); // Fetch debate_id from nearest claim-card
                openControlModal(this, debateId); // Pass debate_id to modal function
            });
        });

        // Function to open the control modal
        function openControlModal(container, debateId) {
            // Create the control modal HTML
            const controlModalHtml = `
                <div class="control-modal">
                    <div class="modal-content">
                        <span class="close close-control-modal">&times;</span>
                        @if (auth()->check())
                        <button class="bookmark-btn" data-debate-id="${debateId}">Loading...</button>
                        @endif
                        <button class="copy-claim-text-btn">Copy Claim Text</button>
                        <button class="claim-link-btn">Copy Claim Link</button>
                        <button class="report-claim-btn">Report Claim</button>
                    </div>
                </div>
                <style>
                    .control-modal {
                        position: fixed;
                        z-index: 1;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: auto;
                        background-color: rgba(0,0,0,0.4);
                    }
                    .flash-modal {
                        position: fixed;
                        top: 20%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        background-color: white;
                        padding: 15px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                        z-index: 9999;
                        display: none;
                        font-size: 16px;
                        font-weight: 700;
                        color: #6a7480;
                        border-radius: 5px;
                    }
                </style>
            `;

            // Append modal HTML to body
            document.body.insertAdjacentHTML('beforeend', controlModalHtml);

            // Add event listeners to the modal buttons
            document.querySelector('.control-modal .close.close-control-modal').addEventListener('click', function(event) {
                event.stopPropagation();
                closeControlModal();
            });
            document.querySelector('.control-modal .copy-claim-text-btn').addEventListener('click', function(event) {
                event.stopPropagation();
                copyClaimText(container);
                closeControlModal();
            });
            document.querySelector('.control-modal .claim-link-btn').addEventListener('click', function(event) {
                event.stopPropagation();
                copyClaimLink(container, debateId);
                closeControlModal();
            });
            document.querySelector('.control-modal .report-claim-btn').addEventListener('click', function(event) {
                event.stopPropagation();
                reportClaim();
                closeControlModal();
            });

            // Add event listener for bookmark button
            document.querySelector('.control-modal .bookmark-btn').addEventListener('click', function(event) {
                event.stopPropagation();
                const debateId = this.getAttribute('data-debate-id');
                toggleBookmark(debateId);
                closeControlModal();
            });

            // Add event listener for clicking outside the modal content
            document.querySelector('.control-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeControlModal();
                }
            });

            // Fetch bookmark status and update the button text
            fetchBookmarkStatus(debateId);
        }

        // Function to close the control modal
        function closeControlModal() {
            const modal = document.querySelector('.control-modal');
            if (modal) {
                modal.remove();
            }
        }

        // Function to fetch bookmark status
        function fetchBookmarkStatus(debateId) {
            fetch('{{ route('debate.isBookmarked') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ debate_id: debateId })
            }).then(response => response.json())
            .then(data => {
                const bookmarkBtn = document.querySelector('.control-modal .bookmark-btn');
                if (data.isBookmarked) {
                    bookmarkBtn.textContent = 'Remove Bookmark';
                    bookmarkBtn.dataset.bookmarked = 'true';
                } else {
                    bookmarkBtn.textContent = 'Bookmark';
                    bookmarkBtn.dataset.bookmarked = 'false';
                }
            }).catch(err => {
                console.error('Failed to fetch bookmark status: ', err);
            });
        }

        // Function to handle toggling bookmark status
        function toggleBookmark(debateId) {
            const bookmarkBtn = document.querySelector('.control-modal .bookmark-btn');
            const isBookmarked = bookmarkBtn.dataset.bookmarked === 'true';

            // AJAX request to toggle bookmark status
            fetch('{{ route('debate.bookmark') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ debate_id: debateId })
            }).then(response => response.json())
            .then(data => {
                if (data.isBookmarked) {
                    bookmarkBtn.textContent = 'Already Bookmarked';
                    bookmarkBtn.dataset.bookmarked = 'true';
                    showFlashModal('Debate bookmarked successfully!');
                } else {
                    bookmarkBtn.textContent = 'Bookmark';
                    bookmarkBtn.dataset.bookmarked = 'false';
                    showFlashModal('Bookmark removed successfully!');
                }
            }).catch(err => {
                console.error('Failed to toggle bookmark status: ', err);
            });
        }

        // Function to copy claim text
        function copyClaimText(container) {
            const debateCard = container.closest('.claim-card');
            const claimTextElement = debateCard.querySelector('.claim-text__content');
            if (claimTextElement) {
                const claimText = claimTextElement.textContent;
                navigator.clipboard.writeText(claimText).then(() => {
                    showFlashModal('Claim text copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                });
            }
        }

        // Function to copy claim link
        function copyClaimLink(container, debateId) {
            const debateCard = container.closest('.claim-card');
            const debateSlug = debateCard.getAttribute('data-debate-slug'); // Fetch debate_slug from nearest claim-card
            if (debateSlug) {
                const claimLink = `${window.location.origin}/debate/${debateSlug}?active=${debateId}`;
                navigator.clipboard.writeText(claimLink).then(() => {
                    showFlashModal('Claim link copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy link: ', err);
                });
            }
        }

        // Function to show flash modal
        function showFlashModal(message) {
            // Create the flash modal HTML
            const flashModalHtml = `
                <div class="flash-modal">${message}</div>
            `;

            // Append flash modal HTML to body
            document.body.insertAdjacentHTML('beforeend', flashModalHtml);

            // Show the flash modal
            const flashModal = document.querySelector('.flash-modal');
            flashModal.style.display = 'block';

            // Remove the flash modal after 2 seconds
            setTimeout(() => {
                flashModal.remove();
            }, 2000);
        }

        // Function to report claim
        function reportClaim() {
            const subject = encodeURIComponent('Report Claim');
            const body = encodeURIComponent('I would like to report this claim.');
            const mailtoLink = `mailto:jmbliss83@gmail.com?subject=${subject}&body=${body}`;
            window.location.href = mailtoLink;
        }
    });


    /////// #####  THANKS FUNCTIONALITY

    function applyThanksFunctionality() {
        document.querySelectorAll('.thanks-btn').forEach(button => {
            // Check if the user has already thanked the activity on page load
            let claimCard = button.closest('.claim-card') || button.closest('.comment-box');
            if (claimCard) {
                let activityId, activityType;
                if (claimCard.classList.contains('claim-card')) {
                    activityId = claimCard.getAttribute('data-debate-id');
                    activityType = 'debate';
                } else if (claimCard.classList.contains('comment-box')) {
                    activityId = claimCard.getAttribute('data-comment-id');
                    activityType = 'comment';
                }

                fetch(`{{ url('/thanks/status') }}/${activityType}/${activityId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.thanked) {
                        button.classList.add('thanked');
                        button.querySelector('i').classList.remove('fa-heart-o');
                        button.querySelector('i').classList.add('fa-heart');
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            // Handle the thank button click
            button.addEventListener('click', function() {
                let claimCard = this.closest('.claim-card') || this.closest('.comment-box');
                if (claimCard) {
                    let activityId, activityType;
                    if (claimCard.classList.contains('claim-card')) {
                        activityId = claimCard.getAttribute('data-debate-id');
                        activityType = 'debate';
                    } else if (claimCard.classList.contains('comment-box')) {
                        activityId = claimCard.getAttribute('data-comment-id');
                        activityType = 'comment';
                    }

                    fetch('{{ route("thanks.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            activity_id: activityId,
                            activity_type: activityType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.classList.add('thanked');
                            this.querySelector('i').classList.remove('fa-heart-o');
                            this.querySelector('i').classList.add('fa-heart');
                        } else {
                            // Optionally, handle the case where the user has already thanked
                            console.warn(data.message || 'Error thanking the user.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                } else {
                    console.error('Error: Unable to find the activity ID.');
                }
            });
        });
    }

    //////######## DYNAMIC TABS

    document.addEventListener('DOMContentLoaded', function() {

        // Apply thanks functionality to all buttons on page load
        applyThanksFunctionality(); 

        // Combined event listener for both .comment-btn and .votes-btn
        document.querySelectorAll('.comment-btn, .votes-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the closest ancestor claim div
                const claim = button.closest('.claims');
                const drawerContainer = claim.querySelector('#detail-drawer-container');

                // Check if the drawer is already open
                if (drawerContainer.innerHTML.trim() !== '') {
                    return; // If drawer is already open, do nothing
                }

                const debateId = claim.querySelector('.claim-card').dataset.debateId;
                const debateSlug = claim.querySelector('.claim-card').dataset.debateSlug;

                // Collect all votes containers
                const voteContainers = [
                    claim.querySelector(`#votesContainer${debateId}`),
                    ...Array.from(claim.querySelectorAll(`[id^="votesContainerAncestor"]`)),
                    ...Array.from(claim.querySelectorAll(`[id^="votesContainerPro"]`)),
                    ...Array.from(claim.querySelectorAll(`[id^="votesContainerCon"]`))
                ].filter(Boolean); // Remove null entries

                const originalParents = voteContainers.map(container => container.parentNode);

                // Determine which drawer should be active
                const isVotesBtn = button.classList.contains('votes-btn');
                const activeDrawerClass = isVotesBtn ? 'voters-drawer' : 'comments-drawer';
                const activeButtonId = isVotesBtn ? 'voters-tab-btn' : 'comments-tab-btn';

                fetch('/load-detail-drawer?debate_id=' + debateId + '&debate_slug=' + debateSlug)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        drawerContainer.innerHTML = data;

                        // Move votes containers inside the voters-drawer tab
                        const votersDrawer = drawerContainer.querySelector('.voters-drawer');
                        const commentsDrawer = drawerContainer.querySelector('.comments-drawer');
                        
                        if (votersDrawer) {
                            voteContainers.forEach(container => {
                                votersDrawer.appendChild(container);
                                container.style.display = 'block';
                            });
                        }

                        // Call the functions to reapply JavaScript logic
                        applyCommentFunctionality();
                        applyThanksFunctionality();

                        // Adding event listeners for the tab buttons
                        drawerContainer.querySelector('#comments-tab-btn').addEventListener('click', function() {
                            toggleDrawer('comments-drawer', drawerContainer);
                            updateActiveButton('comments-tab-btn');
                        });
                        drawerContainer.querySelector('#duplicates-tab-btn').addEventListener('click', function() {
                            toggleDrawer('duplicates-drawer', drawerContainer);
                            updateActiveButton('duplicates-tab-btn');
                        });
                        drawerContainer.querySelector('#flags-tab-btn').addEventListener('click', function() {
                            toggleDrawer('flags-drawer', drawerContainer);
                            updateActiveButton('flags-tab-btn');
                        });
                        drawerContainer.querySelector('#locations-tab-btn').addEventListener('click', function() {
                            toggleDrawer('locations-drawer', drawerContainer);
                            updateActiveButton('locations-tab-btn');
                        });
                        drawerContainer.querySelector('#voters-tab-btn').addEventListener('click', function() {
                            toggleDrawer('voters-drawer', drawerContainer);
                            updateActiveButton('voters-tab-btn');
                        });

                        // Set the current drawer class based on the button clicked
                        if (activeDrawerClass === 'voters-drawer' && votersDrawer) {
                            votersDrawer.classList.add('current_drawer');
                        }
                        if (activeDrawerClass === 'comments-drawer' && commentsDrawer) {
                            commentsDrawer.classList.add('current_drawer');
                        }

                        // Add event listener for the close button
                        drawerContainer.querySelector('.close-detail-drawer').addEventListener('click', function() {
                            closeModal(drawerContainer, voteContainers, originalParents);
                        });

                        // Add event listener for clicking outside the modal
                        document.addEventListener('click', function(event) {
                            if (!drawerContainer.contains(event.target) && !button.contains(event.target)) {
                                closeModal(drawerContainer, voteContainers, originalParents);
                            }
                        }, { once: true });
                        
                        // Set the active button class
                        updateActiveButton(activeButtonId);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    });

    // Function to toggle the drawer class
    function toggleDrawer(activeClass, container) {
        const drawers = container.querySelectorAll('.detail-drawer__content > div');
        let targetDrawer = null;

        drawers.forEach(drawer => {
            if (drawer.classList.contains(activeClass)) {
                targetDrawer = drawer;
            } else {
                drawer.classList.remove('current_drawer');
            }
        });

        if (targetDrawer && !targetDrawer.classList.contains('current_drawer')) {
            targetDrawer.classList.add('current_drawer');
        }
    }

    // Function to update the active button
    function updateActiveButton(activeButtonId) {
        const btnList = document.querySelector('.detail-drawer__btnlist');
        if (btnList) {
            const buttons = btnList.querySelectorAll('button');
            buttons.forEach(button => {
                button.classList.remove('current__detail-btn');
            });
            const activeButton = btnList.querySelector(`#${activeButtonId}`);
            if (activeButton) {
                activeButton.classList.add('current__detail-btn');
            }
        }
    }

    // Function to close the modal and clear the container
    function closeModal(container, voteContainers, originalParents) {
        // Move votes containers back to their original parents
        voteContainers.forEach((container, index) => {
            const originalParent = originalParents[index];
            if (container && originalParent) {
                originalParent.appendChild(container);
                container.style.display = 'none'; // Hide it again
            }
        });

        container.innerHTML = '';
    }



    /******* MARK DEBATE SEEN FUNCTIONALITY  *******/

    // mark as read button click functionality code
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.mark-as-read-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                // Hide the button immediately
                this.style.display = 'none';

                const debateId = this.getAttribute('data-debate-id');

                fetch('{{ route('debate.markAsRead') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        debate_id: debateId
                    }),
                })
                .then(response => response.json())
                .catch(error => console.error('Error:', error));
            });
        });

        // ripple effect on button click

        $(document).on('click', '.mark-as-read-btn', function (e) {
            // Get the parent .claim-card of the clicked button
            var claimCard = $(this).closest('.claim-card');

            // Create the ripple element
            var ripple = $('<span class="ripple"></span>');

            // Append the ripple to the claim-card
            claimCard.append(ripple);

            // Get the click coordinates relative to the claim-card
            var posX = e.pageX - claimCard.offset().left;
            var posY = e.pageY - claimCard.offset().top;

            // Set the size of the ripple (using the largest dimension of the claim-card)
            var rippleSize = Math.max(claimCard.width(), claimCard.height());

            // Position the ripple and set its dimensions
            ripple.css({
                top: posY - rippleSize / 2 + 'px',
                left: posX - rippleSize / 2 + 'px',
                width: rippleSize + 'px',
                height: rippleSize + 'px'
            });

            // After the animation ends, remove the ripple
            ripple.on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function () {
                $(this).remove();
            });
        });
    });


</script>

