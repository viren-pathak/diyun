<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Session;
use Socialite;

class UserController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
    
            $finduser = User::where('google_id', $user->id)->first();
    
            if ($finduser) {
                Auth::login($finduser);
                return view('auth.dashboard');
            } else {
                session([
                    'googleUser' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'avatar' => $user->avatar
                    ]
                ]);
                return redirect('complete-registration');
            }
    
        } catch (Exception $e) {
            return back()->withErrors('Unable to login using Google.');
        }
    }
    

    public function signUp(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }
        return back()->withErrors('Login details are not valid');
    }


    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        return redirect("/")->withSuccess('You are not allowed to access');
    }
    
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect("/");
    }


    public function showCompleteRegistrationForm()
    {
        return view('auth.complete-registration');
    }

    public function completeGoogleRegistration(Request $request)
    {
        $request->validate(['username' => 'required|unique:users']);

        $googleUserData = session('googleUser');
        if (!$googleUserData) {
            return redirect('login')->withErrors('Session has expired, please try again.');
        }

        $user = User::create([
            'username' => $request->username,
            'name' => $googleUserData['name'],
            'email' => $googleUserData['email'],
            'google_id' => $googleUserData['google_id'],
            'password' => encrypt('my-google') // Just a placeholder, not used for login
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }


    public function showResetPasswordForm()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Logic to send reset password email
        // You can use Laravel's built-in Password Broker for this

        // Redirect back with success message
        return back()->with('success', 'Password reset email sent successfully!');
    }


}