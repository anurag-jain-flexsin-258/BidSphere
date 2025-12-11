<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Customer\EmailRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class EmailLoginController extends Controller
{
    /**
     * Show Email Login Page
     */
    public function showEmailForm()
    {
        return view('customer.auth.email-login');
    }

    /**
     * Generate & send OTP
     */
    public function sendOTP(EmailRequest $request)
    {
        $otp = rand(100000, 999999);

        // Create customer if not exists
        $customer = Customer::firstOrCreate(
            ['email' => $request->email],
            ['otp_verified' => false]
        );

        // Update OTP
        $customer->otp = $otp;
        $customer->save();

        // Email OTP
        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Your OTP Code');
        });

        // Redirect to OTP page
        return redirect()
            ->route('customer.verify-otp')
            ->with('email', $request->email);
    }

    /**
     * Resend OTP
     */
    public function resendOTP(EmailRequest $request)
    {
        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'Email not registered']);
        }

        $otp = rand(100000, 999999);

        $customer->otp = $otp;
        $customer->save();

        // Send email
        Mail::raw("Your new OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Resend OTP');
        });

        return redirect()
            ->route('customer.verify-otp')
            ->with('email', $request->email)
            ->with('success', 'OTP resent successfully');
    }

    /**
     * Logout customer
     */
    public function logout()
    {
        Auth::guard('customer')->logout();

        return redirect()->route('customer.login')->with('success', 'Logged out successfully.');
    }
}
