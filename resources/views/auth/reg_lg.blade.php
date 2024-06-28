
<div class="login-form" id="login-popup-form">
        <div class="cotainer">
                   <button type="button" class="close close-button" onclick="closeForm()" aria-label="Close">
                        X
                    </button>
            <div class="card">
                
                <div class="card-header text-center">
                  <h3>  Registrarse</h3>   
                </div>
                <div class="change-form" style="margin:8px;">
                    <a onclick="openSignupForm()" style="color:blue; ">?Sign Up </a>instead
                </div>
                <div style="margin:15px;">
                    <a href="{{ route('login.google') }}" class="btn btn-google">Continue with Google</a>
                </div>
                <div>
                    <p> or</p>
                </div>
              
                <div class="card-body">
              
       
     
        <form id="loginForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
                <span id="emailError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div id="message"></div>
                <input type="password" id="password" name="password" class="form-control">
                <span id="passwordError" class="text-danger"></span>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Login</button>
        </form>
        <div>
            <a href="{{route('user_forget')}}">Forget Password</a>
        </div>
                </div>
            </div>
        </div>
    </div>


    <div class="signup-form" id="signup-popup-form">
        <div class="cotainer">
            <div class="card">
            <button type="button" class="close close-button" onclick="closeForm()" aria-label="Close">
                        X
            </button>
                <div class="card-header text-center">
                    <h3>  Sign up</h3>
                    <div class="change-form" style="margin:8px">
                    <a onclick="openLoginForm()" style="color:blue; ">Login </a>instead?
                </div>
                <div style="margin:15px;">
                             <a href="{{ route('login.google') }}" class="btn btn-google">Continue with Google</a>
                 </div>
                </div>
                <div>
                    <p> or</p>
                </div>
                <div class="container mt-5">
                <form id="registerForm" method="POST">
            @csrf
            <div id="message"></div>
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control">
                <span id="usernameError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control">
                <span id="emailError" class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control">
                <span id="passwordError" class="text-danger"></span>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Register</button>
        </form>
       
    </div>

            </div>
        </div>
    </div>

    <div id="multistep-form-container" style="display: none;">
        <span class="close-icon" onclick="closeMultistepForm()">&#10006;</span>
        @include('debate.multistep-form')
    </div>

    
<script>
 $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.text-danger').text('');
                $('#message').html('');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('register') }}',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#registerForm').trigger('reset');
                        } else {
                            if (response.errors) {
                                $.each(response.errors, function(key, value) {
                                    $('#' + key + 'Error').text(value[0]);
                                });
                            } else {
                                $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
                            $('#message').html('<div class="alert alert-danger">An error occurred while processing your request.</div>');
                        }
                    }
                });
            });
        });


// login js
$(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('.text-danger').text('');
                $('#message').html('');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('login') }}',
                    data: $(this).serialize() + '&redirect_url=' + encodeURIComponent(window.location.href),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                            $('#loginForm').trigger('reset');

                            // Check if there's a redirect URL
                            var redirectUrl = response.redirect_url || '{{ route('home') }}';
                            window.location.href = redirectUrl;
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key + 'Error').text(value[0]);
                            });
                        } else {
                            $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    }
                });
            });
        });

</script>