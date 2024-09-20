<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Mail\RegistrationConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Debate;
use App\Models\DebateRead;
use Session;
use Socialite;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $token = hash('sha256', time());

        $user = new User;
        $user->name = $request->input('username');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->remember_token = $token;
        $user->token = $token;
        $user->save();

        $verificationLink = url('http://127.0.0.1:8000/verify/' . $token);
            Mail::to($user->email)->queue(new RegistrationConfirmation([
                'username' => $user->username,
                'verificationLink' => $verificationLink
            ]));
        

        return response()->json(['success' => true, 'message' => 'User registered successfully!']);
    }

    public function verifyAccount($token) 
    {
        try {
            // Find the user by the provided token
            $user = User::where('token', $token)->firstOrFail();

            // Update user information
            $user->token = null; // Nullify the token to prevent it from being reused
            $user->status = 'active'; // Set the user's status to active
            $user->save(); // Save the changes to the user model

            // Log in the user
            Auth::login($user);

            // Redirect to the desired location (e.g., home page)
            return redirect('/')->with('message', 'Email verified successfully!');
        } catch (\Exception $e) {
            // Handle exceptions such as user not found or other errors
            return redirect('/invalid-token')->with('message', 'User not found or invalid token!');
        }
    }

    public function invalid() {
        return view('page.invalid');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google authentication failed');
        }

        // Check if the user already exists in the database
        $existingUser = User::where('email', $googleUser->email)->first();

        if ($existingUser) {
            // Log in the existing user
            Auth::login($existingUser);
        } else {
            // Create a new user record
            $newUser = new User();
            $newUser->email = $googleUser->email;

            // Generate a unique username
            $baseUsername = strtolower(str_replace(' ', '', $googleUser->name));
            $username = $this->makeUsernameUnique($baseUsername);

            $newUser->username = $username;
            // You may want to generate a random password or handle it differently
            $newUser->password = bcrypt('reb8fx123');
            $newUser->status = 'active';
            $newUser->save();

            // Log in the new user
            Auth::login($newUser);
        }

        return redirect()->route('home'); // Adjust the route as needed
    }
    
    private function makeUsernameUnique($baseUsername)
    {
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to log in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Determine where to redirect after login
            $redirectUrl = $request->input('redirect_url') ?: route('home');
    
            return response()->json(['success' => true, 'message' => 'Login successful!', 'redirect_url' => $redirectUrl]);
        }

        // Check if the email exists and the password is incorrect
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user && !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password does not match.'], 401);
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
    }


    public function dashboard()
    {
        if (Auth::check()) {
            // Create an instance of DebateController
            $debateController = new \App\Http\Controllers\DebateController();

            // Call the myFollowing method from DebateController
            $debateStats = $debateController->myFollowing();

            // Pass the debates to the dashboard view
            return view('auth.dashboard', compact('debateStats'));
        }
        return redirect("/")->withSuccess('You are not allowed to access');
    }
    
    public function logout(Request $request)
    {
        $redirectTo = $request->input('redirect_to', '/');
        Session::flush();
        Auth::logout();
        return redirect($redirectTo);
    }
    
        public function user_forget(Request $request)
    {
        return view('auth.forget-password');
    }


    public function user_forget_2(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = User::where('email', $request->input('email'))->first();
    
        if ($user) {
            // Use Laravel's built-in password reset functionality
          
            $token = app('auth.password.broker')->createToken($user, [
                'expires' => now()->addMinutes(1), // Set the expiration time to 10 minutes
            ]);
    
            // Update user information
            $user->password = Hash::make("diyun123");
            $user->token = $token;
            $user->save();
    
            $verificationLink = url('http://127.0.0.1:8000/new-password/'.$token.'/');
            $mailSubject = "Reset Password";
            $userData = [
                'email' => $request->input('email'),
                'link' => $verificationLink,
            ];
    
            Mail::to($request->input('email'))->send(new ForgetPassword($mailSubject, $userData));
           
            return redirect('/forget-password')->with('message', ' Check your email inbox for the password reset link !');
            
        } else {
            return redirect('/forget-password')->with('message', 'No account found with the provided email address.');
        }
    }

    public function user_new_password($token)
    {
        return view('auth.new_password', ['token' => $token]);
    }
    
    public function verifyAccount_2($token, Request $request)
    {
        // Validate request data
        $request->validate([
            'password' => 'required|min:8', // Add more validation rules as needed
        ]);
    
        $user = User::where('token', $token)->first();
    
        if (!$user) {
            return redirect('/')->with('message', 'User not found or invalid token !!');
        }
    
        // Clear the token and update the password
        $user->token = null;
        $user->password = Hash::make($request->password);
        $user->save();
    
        return redirect('/')->with('message', 'Password Update successful!');
    
    }

}