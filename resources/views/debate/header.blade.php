{{-- SINGLE DEBATE PAGE HEADER --}}
    <header>
        <div class=" header-row topbar--on-discussion">
            <div class="col-1 topbar--col1">

                {{-- LOGO --}}
                <div class="logo-div">
                    <a href="{{ route('home') }}"><img class="white" src="{{ asset('uploads/White-logo.png')}}" alt="logo" style="width: 80px" /></a>
                    
                    <a href="{{ route('home') }}"><img class="blue" src="{{ asset('uploads/Blue-logo.png')}}" alt="logo" style="width: 80px" /></a>
                </div>

                {{-- Single Debate Menu Icon (hide in settings) --}}
                @if(!$hideButtons)
                    <button aria-label="Menu" class="sidebar-toggle single-page-menu">
                        <span class="icon-svg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </span>
                    </button>
                @endif

                {{-- Root Debate Title --}}
                <div class="topbar-title debate-single-title">
                    @isset($rootDebate)
                    <a href="/debate/{{ $rootDebate->slug }}?active={{ $rootDebate->id }}">
                        <p class="topbar-debate-title">{{ $rootDebate->title }}</p>
                    </a>
                    @endisset
                </div>

            </div>

            <div class="col-2 topbar--col2">
               
                @if(!$hideButtons)
                    {{-- Single Debate Chat Icon (Hide in settings) --}}
                    <button aria-label="Chat" class="sidebar-toggle single-page-chat">
                        <span class="icon-svg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </span>
                    </button>

                    {{-- Single Debate Notifications Icon (Hide in settings) --}}
                    <button aria-label="Notifications - with highlighted dot" class="sidebar-toggle single-page-notifications">
                        <span class="icon-svg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
                            </svg>
                        </span>
                    </button>
                @endif

                @guest
                    <li class="nav-item">
                        <a class="nav-link" onclick="openLoginForm()">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="openSignupForm()">Signup</a>
                    </li>
                @endguest
                
                {{-- User Account Menu --}}
                <div class="single-page__account-menu-button account-menu-button" aria-label="Logout and personal settings">
                </div>
            </div>
        </div>
    </header>

    @include('auth.reg_lg')