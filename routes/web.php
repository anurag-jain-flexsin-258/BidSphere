<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Auth\EmailLoginController;
use App\Http\Controllers\Customer\Auth\OTPVerificationController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\TenderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Customer-facing routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->name('customer.')->group(function () {

    // -----------------------
    // Guest Routes
    // -----------------------
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [EmailLoginController::class, 'showEmailForm'])->name('login');
        Route::post('/login', [EmailLoginController::class, 'sendOTP'])->name('send-otp');
        Route::post('/resend-otp', [EmailLoginController::class, 'resendOTP'])->name('resend-otp');
        Route::get('/verify-otp', [OTPVerificationController::class, 'showOTPForm'])->name('verify-otp');
        Route::post('/verify-otp', [OTPVerificationController::class, 'verifyOTP'])->name('otp.verify');
    });

    // -----------------------
    // Authenticated Routes
    // -----------------------
    Route::middleware('auth:customer')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Logout
        Route::post('/logout', [EmailLoginController::class, 'logout'])->name('logout');

        // Customer Tender Routes (RESTful)
        Route::resource('tenders', TenderController::class);
    });

});