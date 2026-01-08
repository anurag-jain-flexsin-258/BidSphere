<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Auth\EmailLoginController;
use App\Http\Controllers\Customer\Auth\OTPVerificationController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\TenderController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('customer')->name('customer.')->group(function () {
    // Guest routes
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [EmailLoginController::class, 'showEmailForm'])->name('login');
        Route::post('/login', [EmailLoginController::class, 'sendOTP'])->name('send-otp');
        Route::post('/resend-otp', [EmailLoginController::class, 'resendOTP'])->name('resend-otp');
        Route::get('/verify-otp', [OTPVerificationController::class, 'showOTPForm'])->name('verify-otp');
        Route::post('/verify-otp', [OTPVerificationController::class, 'verifyOTP'])->name('otp.verify');
    });

    // Authenticated routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [DashboardController::class, 'editProfile'])->name('profile.edit');
        Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
        Route::post('/logout', [EmailLoginController::class, 'logout'])->name('logout');
        
        // Customer Tender routes
        Route::resource('tenders', TenderController::class);
    });

});
