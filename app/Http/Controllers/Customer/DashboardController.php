<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Customer\ProfileUpdateRequest;

class DashboardController extends Controller
{
    /**
     * Show dashboard.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.dashboard.index', compact('customer'));
    }

    /**
     * Show profile edit form.
     */
    public function editProfile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.dashboard.profile', compact('customer'));
    }

    /**
     * Update profile.
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $customer = Auth::guard('customer')->user();

        $data = $request->only(['name','phone','gender','dob','address','gst_no']);

        // Upload image if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/customers'), $name);
            $data['image'] = 'uploads/customers/' . $name;
        }

        $data['profile_completed'] = true;

        $customer->update($data);

        return redirect()->route('customer.dashboard')->with('success', 'Profile updated successfully.');
    }
}
