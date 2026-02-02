{{--
|--------------------------------------------------------------------------
| OTP Verification
|--------------------------------------------------------------------------
| - Simple, focused verification screen
| - Prevents accidental edits to email
|--------------------------------------------------------------------------
--}}

@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">

        <div class="app-card p-4 p-md-5">

            {{-- Header --}}
            <div class="text-center mb-4">
                <h4 class="fw-semibold mb-1">Verify OTP</h4>
                <p class="text-muted small">
                    Enter the 6-digit code sent to your email
                </p>
            </div>

            {{-- Session Error --}}
            @if (session('error'))
                <div class="alert alert-danger small">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('customer.verify-otp') }}" method="POST">
                @csrf

                {{-- Email (read-only) --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $email) }}"
                           class="form-control"
                           readonly>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- OTP --}}
                <div class="mb-4">
                    <label class="form-label fw-medium">OTP</label>
                    <input type="text"
                           name="otp"
                           value="{{ old('otp') }}"
                           class="form-control text-center tracking-widest"
                           placeholder="● ● ● ● ● ●"
                           maxlength="6"
                           required>
                    @error('otp')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                        class="btn btn-success w-100 py-2">
                    Verify & Continue
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
