<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegisterController;
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

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('auth.login');
    Route::post('login', [LoginController::class, 'post'])->name('auth.login.post');
    Route::get('otp', [OtpController::class, 'index'])->name('auth.otp');
    Route::post('otp', [OtpController::class, 'verifyOtp'])->name('auth.otp.post');
    Route::get('register', [RegisterController::class, 'index'])->name('auth.register');
    Route::post('register', [RegisterController::class, 'post'])->name('auth.register.post');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('auth.dashboard');
    Route::get('logout', [DashboardController::class, 'logout'])->name('auth.logout');
});