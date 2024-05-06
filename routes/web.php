<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DebateController;

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

// Route::get('/', function () {
//     return view('home');
// })->name('home');

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


Route::get('/debate/step1', [DebateController::class, 'showStep1Form'])->name('debate.step1');
Route::post('/debate/step1', [DebateController::class, 'processStep1']);
Route::get('/debate/step2', [DebateController::class, 'showStep2Form'])->name('debate.step2');
Route::post('/debate/step2', [DebateController::class, 'processStep2']);
Route::get('/debate/step3', [DebateController::class, 'showStep3Form'])->name('debate.step3');
Route::post('/debate/step3', [DebateController::class, 'processStep3']);
Route::get('/debate/step4', [DebateController::class, 'showStep4Form'])->name('debate.step4');
Route::post('/debate/step4', [DebateController::class, 'processStep4']);

Route::get('/', [DebateController::class, 'getAllDebates'])->name('home');

