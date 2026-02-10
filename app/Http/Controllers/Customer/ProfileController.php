<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\ProfileUpdateRequest;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileController extends Controller
{
    /**
     * Display the customer's profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // Get the currently authenticated customer
        $customer = Auth::guard('customer')->user();

        return view('customer.profile.edit', compact('customer'));
    }

    /**
     * Update the customer's profile.
     *
     * Handles all profile fields and optional profile image upload.
     *
     * @param  \App\Http\Requests\Customer\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If profile update fails
     */
    public function update(ProfileUpdateRequest $request)
    {
        $customer = Auth::guard('customer')->user();

        try {
            // Only allow specific fields
            $data = $request->only([
                'name',
                'phone',
                'gender',
                'dob',
                'address',
                'gst_no',
            ]);

            // Handle profile image upload if present
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move(public_path('uploads/customers'), $filename);
                $data['image'] = 'uploads/customers/' . $filename;
            }

            // Mark profile as completed
            $data['profile_completed'] = true;

            // Update customer profile
            $customer->update($data);

            return redirect()
                ->route('customer.dashboard')
                ->with('success', 'Profile updated successfully.');
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Profile update failed for customer ID ' . $customer->id . ': ' . $e->getMessage());

            // Redirect back with error message
            return redirect()
                ->back()
                ->withErrors('An error occurred while updating your profile. Please try again.');
        }
    }
}