<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display the customer's dashboard.
     *
     * Currently shows a simple placeholder.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Exception If fetching customer data fails
     */
    public function index()
    {
        try {
            // Get the currently authenticated customer
            $customer = Auth::guard('customer')->user();

            // Return the dashboard view with customer data
            return view('customer.dashboard.index', compact('customer'));
        } catch (Exception $e) {
            // Log the error for debugging
            \Log::error('Dashboard load failed for customer: ' . ($customer->id ?? 'guest') . '. Error: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->withErrors('Unable to load dashboard at this time.');
        }
    }
}