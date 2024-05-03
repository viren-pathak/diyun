<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::post('signUp', [UserController::class, 'signUp'])->name('signUp');
Route::post('login', [UserController::class, 'login'])->name('login');
Route::get('logout', [UserController::class, 'logout'])->name('logout');


Route::get('login/google', [UserController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [UserController::class, 'handleGoogleCallback']);


Route::get('complete-registration', [UserController::class, 'showCompleteRegistrationForm'])->name('show-complete-registration');
Route::post('complete-google-registration', [UserController::class, 'completeGoogleRegistration'])->name('complete-google-registration');


Route::get('reset-password', [UserController::class, 'showResetPasswordForm'])->name('show-reset-password-form');
Route::post('reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
