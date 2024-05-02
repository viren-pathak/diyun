<!DOCTYPE html>
<html>
<head>
    <title>Diyun</title>
    <style>
        .login-form, .signup-form {
            display: none; /* Hidden by default */
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid #f1f1f1;
            z-index: 9;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{'/'}}">Diyun</a>

            <div class="navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" onclick="openLoginForm()">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="openSignupForm()">Signup</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-form" id="login-popup-form">
        <div class="cotainer">
            <div class="card">
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
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Email" id="email" class="form-control" name="email" required autofocus>
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
                            <button type="submit" class="btn btn-dark btn-block">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="signup-form" id="signup-popup-form">
        <div class="cotainer">
            <div class="card">
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

    <div class="container mt-5">
        @yield('content')
    </div>

    <script>
        function openLoginForm() {
            var loginForm = document.getElementById("login-popup-form");
            var signupForm = document.getElementById("signup-popup-form");
            if (signupForm.style.display === "block") {
                signupForm.style.display = "none";
            }
            loginForm.style.display = "block";
        }

        function openSignupForm() {
            var signupForm = document.getElementById("signup-popup-form");
            var loginForm = document.getElementById("login-popup-form");
            if (loginForm.style.display === "block") {
                loginForm.style.display = "none";
            }
            signupForm.style.display = "block";
        }

        function closeForm() {
            document.getElementById("login-popup-form").style.display = "none";
            document.getElementById("signup-popup-form").style.display = "none";
        }

    </script>
</body>
</html>