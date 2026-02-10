<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Auth\EmailLoginController;
use App\Http\Controllers\Customer\Auth\OTPVerificationController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\TenderController;
use App\Http\Controllers\Feed\FeedController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Public Feed (Visible to Everyone)
|--------------------------------------------------------------------------
*/

Route::get('/', [FeedController::class, 'index'])->name('feed.index');
Route::get('/feed/{tender}', [FeedController::class, 'show'])->name('feed.show');

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->name('customer.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Guest Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [EmailLoginController::class, 'showEmailForm'])->name('login');
        Route::post('/login', [EmailLoginController::class, 'sendOTP'])->name('send-otp');
        Route::post('/resend-otp', [EmailLoginController::class, 'resendOTP'])->name('resend-otp');
        Route::get('/verify-otp', [OTPVerificationController::class, 'showOTPForm'])->name('verify-otp');
        Route::post('/verify-otp', [OTPVerificationController::class, 'verifyOTP'])->name('otp.verify');
    });

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:customer')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Logout
        Route::post('/logout', [EmailLoginController::class, 'logout'])->name('logout');

        // Customer Tender CRUD
        Route::resource('tenders', TenderController::class);

        /*
        |--------------------------------------------------------------------------
        | Feed Interaction (Auth Required)
        |--------------------------------------------------------------------------
        */

        Route::post('/feed/{tender}/like', [FeedController::class, 'toggleLike'])
            ->name('feed.like');
    });
});