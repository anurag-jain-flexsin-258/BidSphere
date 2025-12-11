{{-- resources/views/welcome.blade.php --}}

@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="text-center mt-5">
        @auth('customer')
            {{-- If customer is logged in --}}
            <h1>Welcome back, {{ Auth::guard('customer')->user()->name }}!</h1>
            <p class="lead">Go to your dashboard to manage your courses and profile.</p>

            <div class="mt-4">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-success">Go to Dashboard</a>
                <form action="{{ route('customer.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger ms-2">Logout</button>
                </form>
            </div>
        @else
            {{-- If customer is not logged in --}}
            <h1>Welcome to Bidsphere</h1>
            <p class="lead">Get started by logging in or registering below.</p>

            <div class="mt-4">
                <a href="{{ route('customer.login') }}" class="btn btn-primary me-2">Login/Register</a>
            </div>
        @endauth
    </div>
@endsection
