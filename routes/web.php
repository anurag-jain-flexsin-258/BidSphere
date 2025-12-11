<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Auth\EmailLoginController;
use App\Http\Controllers\Customer\Auth\OTPVerificationController;
use App\Http\Controllers\Customer\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('customer')->name('customer.')->group(function () {

    // Email Login
    Route::get('/login', [EmailLoginController::class, 'showEmailForm'])->name('login');
    Route::post('/login', [EmailLoginController::class, 'sendOTP'])->name('send-otp');

    // Resend OTP
    Route::post('/resend-otp', [EmailLoginController::class, 'resendOTP'])->name('resend-otp');

    // OTP Verification
    Route::get('/verify-otp', [OTPVerificationController::class, 'showOTPForm'])->name('verify-otp');
    Route::post('/verify-otp', [OTPVerificationController::class, 'verifyOTP'])->name('otp.verify');

    // Logout
    Route::post('/logout', [EmailLoginController::class, 'logout'])
        ->name('logout')
        ->middleware('auth:customer');

    // Auth-protected routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    });
});
