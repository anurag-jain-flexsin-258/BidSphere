<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\CustomerDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Customer Routes
Route::prefix('customer')->name('customer.')->group(function () {

    Route::get('register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [CustomerAuthController::class, 'register']);

    Route::get('login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [CustomerAuthController::class, 'sendOtp']);

    Route::get('verify-otp', [CustomerAuthController::class, 'showOtpForm'])->name('verify.otp');
    Route::post('verify-otp', [CustomerAuthController::class, 'verifyOtp']);

    Route::post('logout', [CustomerAuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', [CustomerDashboardController::class, 'index'])->middleware('auth:customer')->name('dashboard');
});
