<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('customer.auth.register');
    }

    /**
     * Handle customer registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:customers,email',
            'phone'=>'required|unique:customers,phone',
            'gender'=>'required',
            'dob'=>'required|date',
            'address'=>'required|string',
            'gst_no'=>'nullable|string',
            'image'=>'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('customer_images','public');
        }

        $customer = Customer::create($data);

        return redirect()->route('customer.login')->with('success','Registration successful. Login to continue.');
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    /**
     * Send OTP for login
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email'=>'required|email']);

        $customer = Customer::where('email',$request->email)->first();
        if(!$customer){
            return back()->withErrors(['email'=>'Email not registered']);
        }

        $otp = rand(100000,999999);
        $customer->otp = $otp;
        $customer->save();

        // Send OTP via email
        Mail::raw("Your OTP is $otp", function($message) use ($customer){
            $message->to($customer->email)->subject('Your OTP Code');
        });

        // Store email in session for OTP verification
        session(['email' => $customer->email]);

        return redirect()->route('customer.verify.otp')->with('success','OTP has been sent to your email.');
    }

    /**
     * Show OTP verification form
     */
    public function showOtpForm()
    {
        $email = session('email');
        return view('customer.auth.verify-otp', compact('email'));
    }

    /**
     * Verify OTP and login customer
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'otp'=>'required|digits:6'
        ]);

        $customer = Customer::where('email',$request->email)
            ->where('otp',$request->otp)
            ->first();

        if(!$customer){
            return back()->withErrors(['otp'=>'Invalid OTP']);
        }

        // Clear OTP and mark email verified
        $customer->otp = null;
        $customer->email_verified_at = now();
        $customer->save();

        // Login customer
        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard')->with('success','Logged in successfully.');
    }

    /**
     * Logout customer
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')->with('success','Logged out successfully.');
    }
}
