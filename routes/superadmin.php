<?php


use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SuperadminController;
use App\Http\Controllers\SiteSettingController;
use Illuminate\Support\Facades\Route;



Route::get('dashboard', [SuperadminController::class, 'dashboard'])->name('sadmin.dashboard');

// profile routes

Route::get('profile', [ProfileController::class, 'index'])->name('sadmin.profile');
Route::post('profile', [ProfileController::class, 'updateprofile'])->name('sadmin.updateprofile');
Route::post('profile/update/password', [ProfileController::class, 'updatepassword'])->name('sadmin.updatepassword');


Route::resource('settings', SiteSettingController::class);
