
    <header>
        <div class=" header-row flex flex-align-center flex-justify-between white-text">
            <div class="col-1 flex flex-align-center flex-justify-end">
                <div class="logo-div">
                    <a href="{{ route('home') }}"><img class="white" src="{{ asset('uploads/White-logo.png')}}" alt="logo" style="width: 80px" /></a>
                    
                    <a href="{{ route('home') }}"><img class="blue" src="{{ asset('uploads/Blue-logo.png')}}" alt="logo" style="width: 80px" /></a>
                </div>
                <div class="menu-div">
                    <ul class="flex flex-align-center">
                        <li><a href="#">My</a></li>
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

    <div class="login-form" id="login-popup-form" style="display: none;">
        <div class="container">
            <div class="card">
                <a href="{{ route('login.google') }}" class="btn btn-danger">Continue with Google</a>
                <div class="card-header text-center">
                    Login
                    <button type="button" class="close" onclick="closeForm()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="change-form">
                    <a onclick="openSignupForm()">Sign Up </a>instead?
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                        </div>
                        <div class="submit-btn">
                            <button type="submit" class="btn btn-dark btn-block">Log in</button>
                        </div>

                        <div class="card-footer forgot-pass-btn">
                            <a href="{{ route('show-reset-password-form') }}">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="signup-form" id="signup-popup-form" style="display: none;">
        <div class="container">
            <div class="card">
                <a href="{{ route('login.google') }}" class="btn btn-danger">Continue with Google</a>
                <div class="card-header text-center">
                    Signup
                    <button type="button" class="close" onclick="closeForm()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="change-form">
                    <a onclick="openLoginForm()">Login </a>instead?
                </div>
                <div class="card-body">
                    <form action="{{ route('signUp') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Username" id="username" class="form-control" name="username" required autofocus>
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Email" id="email_address" class="form-control" name="email" required autofocus>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="multistep-form-container" style="display: none;">
        <span class="close-icon" onclick="closeMultistepForm()">&#10006;</span>
        @include('debate.multistep-form')
    </div>
