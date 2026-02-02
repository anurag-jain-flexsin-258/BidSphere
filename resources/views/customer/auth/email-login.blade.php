{{--
|--------------------------------------------------------------------------
| Email Login (Send OTP)
|--------------------------------------------------------------------------
| - Focused, distraction-free layout
| - Clear input and primary action
|--------------------------------------------------------------------------
--}}

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="app-card p-4 p-md-5">

            {{-- Header --}}
            <div class="text-center mb-4">
                <h4 class="fw-semibold mb-1">Login with Email</h4>
                <p class="text-muted small">
                    We’ll send a one-time password to your email
                </p>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert alert-danger small">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('customer.send-otp') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-medium">Email address</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="you@example.com"
                           required>
                </div>

                <button type="submit"
                        class="btn btn-primary w-100 py-2">
                    Send OTP
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
