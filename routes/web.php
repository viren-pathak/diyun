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

Route::get('invalid-token', [UserController::class, 'invalid'])->name('invalid');

Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/forget-password', [UserController::class, 'user_forget'])->name('user_forget');
Route::post('/forget-password', [UserController::class, 'user_forget_2'])->name('user_forget_2');

Route::get('/new-password/{token}', [UserController::class, 'user_new_password'])->name('user_new_password');
Route::post('/update-password/{token}', [UserController::class, 'verifyAccount_2'])->name('update_password');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


Route::get('/login/google', [UserController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/login/google/callback', [UserController::class, 'handleGoogleCallback']);


Route::get('/complete-registration', [UserController::class, 'showCompleteRegistrationForm'])->name('show-complete-registration');
Route::post('/complete-google-registration', [UserController::class, 'completeGoogleRegistration'])->name('complete-google-registration');


Route::get('/reset-password', [UserController::class, 'showResetPasswordForm'])->name('show-reset-password-form');
Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');


Route::post('/debate/create-debate', [DebateController::class, 'createDebate'])->name('debate.createDebate');
Route::get('/debate/{slug}', [DebateController::class, 'single'])->name('debate.single');
Route::get('/get-child-arguments/{slug}', [DebateController::class, 'getChildArguments'])->name('debate.getChildArguments');
Route::get('/debate/{slug}/settings', [DebateController::class, 'settings'])->name('settings');
Route::post('/debate/{slug}/edit', [DebateController::class, 'editRootDebate'])->name('editRootDebate');
Route::post('/debate/update-title/{id}', [DebateController::class, 'updateDebateTitle'])->name('updateDebateTitle');
Route::get('/debate/{slug}/export', [DebateController::class, 'exportDebate'])->name('exportDebate');

Route::post('/debate/bookmark', [DebateController::class, 'bookmark'])->name('debate.bookmark');
Route::get('debate/{slug}/bookmarks', [DebateController::class, 'getUserBookmarks'])->name('debate.bookmarks');
Route::post('/debate/is-bookmarked', [DebateController::class, 'isBookmarked'])->name('debate.isBookmarked');

Route::post('/debate/mark-as-read', [DebateController::class, 'markAsRead'])->name('debate.markAsRead');

Route::get('/', [DebateController::class, 'getHomeData'])->name('home');

Route::get('/tags/{tag}', [DebateController::class, 'getDebatesByTag'])->name('tags.single');
Route::get('/tags', [DebateController::class, 'getAllTags'])->name('tags');

Route::post('/add-pro/{id}', [DebateController::class, 'addPro'])->name('debate.addPro');
Route::post('/add-con/{id}', [DebateController::class, 'addCon'])->name('debate.addCon');
Route::post('/comment/{id}', [DebateController::class, 'addComment'])->name('debate.comment');
Route::post('/comments/edit/{comment}', [DebateController::class, 'editComment'])->name('comments.edit');
Route::delete('/comments/delete/{id}', [DebateController::class, 'deleteComment'])->name('comments.delete');

Route::post('/debate/{debate}/vote', [DebateController::class, 'vote'])->name('debate.vote');
Route::delete('/debate/{debateId}/vote', [DebateController::class, 'deleteVote'])->name('debate.deleteVote');

Route::post('/debate/sendInvite', [DebateController::class, 'sendInvite'])->name('debate.sendInvite');

Route::post('/thanks', [DebateController::class, 'storeThanks'])->name('thanks.store');
Route::get('/thanks/status/{type}/{id}', [DebateController::class, 'checkThanksStatus'])->name('thanks.status');

/***** ROUTES FOR static PAGES *****/

Route::get('/about', [Basecontroller::class, 'about'])->name('about.page');
Route::get('/privacy', [Basecontroller::class, 'Privacy_Policy'])->name('Privacy.page');
Route::get('/contact', [Basecontroller::class, 'contact'])->name('contact.page');
Route::get('/help', [Basecontroller::class, 'help'])->name('help.page');
Route::get('/search', [Basecontroller::class, 'search'])->name('search.page');


/**** USER RELATED ROUTES IN SINGLE DEBATE PAGE *****/

Route::get('/debate/{slug}/my-claims', [DebateController::class, 'getMyClaims'])->name('debate.my_claims');
Route::get('/debate/{slug}/contributions', [DebateController::class, 'getMyContributions'])->name('debate.contributions');
Route::get('/debate/my-following', [DebateController::class, 'myFollowing'])->name('debate.myFollowing');


/**** SPECIAL ROUTE FOR NOTIFICATIONS TAB ****/
Route::get('/notification/{tab}', function($tab) {
    if (in_array($tab, ['changes', 'activity', 'global'])) {
        return view("notification.$tab");
    }
    return abort(404);
});


Route::get('/load-detail-drawer', [DebateController::class, 'loadDetailDrawer']);