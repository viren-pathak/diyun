
    <header>
        <div class=" header-row flex flex-align-center flex-justify-between white-text">
            <div class="col-1 flex flex-align-center flex-justify-end">
                <div class="logo-div">
                    <a href="{{ route('home') }}"><img class="white" src="{{ asset('uploads/White-logo.png')}}" alt="logo" style="width: 80px" /></a>
                    
                    <a href="{{ route('home') }}"><img class="blue" src="{{ asset('uploads/Blue-logo.png')}}" alt="logo" style="width: 80px" /></a>
                </div>
                <div class="menu-div">
                    <ul class="flex flex-align-center">
                        <li><a href="{{route('dashboard') }}">My</a></li>
                        <li><a href="#">Explore</a></li>
                        <li><a href="{{ route('search.page') }}"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-2 flex flex-align-center flex-justify-end">
                <div class="profile"></div>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" onclick="openLoginForm()">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="openSignupForm()">Signup</a>
                        </li>
                    @endguest
                    @auth
                        <button onclick="openMultistepForm()">New +</button>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>

                    @endauth
                </div>
            </div>
        </div>
    </header>
    @include('auth.reg_lg')