<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class CustomerDashboardController extends Controller
{
    /**
     * Show customer dashboard
     */
    public function index()
    {
        return view('customer.dashboard');
    }
}
