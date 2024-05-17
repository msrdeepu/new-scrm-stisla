<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\SuperadminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Front\EmployeeController;
use App\Http\Controllers\Front\HomeController;
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
