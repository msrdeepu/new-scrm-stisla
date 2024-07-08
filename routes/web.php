<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\SuperadminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Front\EmployeeController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MessengerController;
use App\Http\Controllers\Front\UserProfileController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/default/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('default.dashboard');


Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';


Route::get('/superadmin/login', [SuperadminController::class, 'login'])->name('superadmin.login');


Route::group(['middleware' => 'auth'], function () {
    Route::get('messenger', [MessengerController::class, 'index'])->name('messenger.home');
    Route::post('profile', [UserProfileController::class, 'update'])->name('userprofile.update');

    // search users with ajax
    Route::get('messenger/search', [MessengerController::class, 'search'])->name('messenger.search');
    //getting user data with ajax for view update
    Route::get('messenger/id-info', [MessengerController::class, 'fetchIdInfo'])->name('messenger.id-info');

    //send message with ajax
    Route::post('messenger/send-message', [MessengerController::class, 'sendMessage'])->name('messenger.send-message');

    //fetch messege
    Route::get('messenger/fetch-messages', [MessengerController::class, 'fetchMessages'])->name('messenger.fetch-messages');

    //fetch contacs
    Route::get('messenger/fetch-contscts', [MessengerController::class, 'fetchContacts'])->name('messenger.fetch-contacts');

    //update contacts
    Route::get('messenger/update-contsct-item', [MessengerController::class, 'updateContactItem'])->name('messenger.update-contact-item');
    //update message view status
    Route::post('messenger/make-seen', [MessengerController::class, 'makeSeen'])->name('messenger.make-seen');
    //favorite contacts
    Route::post('messenger/favorite', [MessengerController::class, 'favorite'])->name('messenger.favorite');
    //fetch favorite contacts
    Route::get('messenger/fetch-favorite', [MessengerController::class, 'fetchFavoritesList'])->name('messenger.fetch-favorite');
    //delete messages
    Route::delete('messenger/delete', [MessengerController::class, 'deleteMessage'])->name('messenger.deletemessage');
});
