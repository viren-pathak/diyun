<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DebateController;
use App\Http\Controllers\BaseController;

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


Route::post('/debate/create-debate', [DebateController::class, 'createDebate'])->name('debate.createDebate');
Route::get('/{slug}', [DebateController::class, 'single'])->name('debate.single');
Route::get('/get-child-arguments/{slug}', [DebateController::class, 'getChildArguments'])->name('debate.getChildArguments');


Route::get('/', [DebateController::class, 'getHomeData'])->name('home');

Route::get('/tags/{tag}', [DebateController::class, 'getDebatesByTag'])->name('tags.single');
Route::get('tags', [DebateController::class, 'getAllTags'])->name('tags');

Route::post('/add-pro/{id}', [DebateController::class, 'addPro'])->name('debate.addPro');
Route::post('/add-con/{id}', [DebateController::class, 'addCon'])->name('debate.addCon');
Route::post('/comment/{id}', [DebateController::class, 'addComment'])->name('debate.comment');

/***** ROUTES FOR static PAGES *****/

Route::get('/about', [Basecontroller::class, 'about'])->name('about.page');
Route::get('/privacy', [Basecontroller::class, 'Privacy_Policy'])->name('Privacy.page');
Route::get('/contact', [Basecontroller::class, 'contact'])->name('contact.page');
Route::get('/help', [Basecontroller::class, 'help'])->name('help.page');
Route::get('/search', [Basecontroller::class, 'search'])->name('search.page');