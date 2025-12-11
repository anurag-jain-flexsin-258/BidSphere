<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\OTPRequest;
use App\Models\Customer;

class OTPVerificationController extends Controller
{
    /**
     * Show OTP Form
     */
    public function showOTPForm()
    {
        $email = session('email') ?? '';
        return view('customer.auth.otp-verification', compact('email'));
    }

    /**
     * Verify OTP
     */
    public function verifyOTP(OTPRequest $request)
    {
        $customer = Customer::where('email', $request->email)
                            ->where('otp', $request->otp)
                            ->first();

        if (!$customer) {
            return redirect()
                ->route('customer.verify-otp')
                ->with('email', $request->email)
                ->withErrors(['otp' => 'Invalid OTP']);
        }

        // Mark as verified
        $customer->otp_verified = true;
        $customer->otp = null;
        $customer->save();

        // Login with customer guard
        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }
}
