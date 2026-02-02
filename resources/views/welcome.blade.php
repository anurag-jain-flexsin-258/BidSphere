{{--
|--------------------------------------------------------------------------
| Welcome / Landing Page
|--------------------------------------------------------------------------
| - Entry point for customers
| - Auth-aware (guest vs logged-in)
| - Clear primary actions
|--------------------------------------------------------------------------
--}}

@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="app-card p-5 text-center">

            @auth('customer')
                {{-- Logged-in state --}}
                <h1 class="fw-bold mb-3">
                    Welcome back, {{ Auth::guard('customer')->user()->name }} 👋
                </h1>

                <p class="text-muted mb-4">
                    You’re all set. Manage your profile and tenders from your dashboard.
                </p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('customer.dashboard') }}"
                       class="btn btn-primary px-4">
                        Go to Dashboard
                    </a>

                    <form action="{{ route('customer.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-danger px-4">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                {{-- Guest state --}}
                <h1 class="fw-bold mb-3">
                    Welcome to Bidsphere
                </h1>

                <p class="text-muted mb-4">
                    Login or register to create and manage your tenders effortlessly.
                </p>

                <a href="{{ route('customer.login') }}"
                   class="btn btn-primary btn-lg px-5">
                    Get Started
                </a>
            @endauth

        </div>

    </div>
</div>
@endsection
