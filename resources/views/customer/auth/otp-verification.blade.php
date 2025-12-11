@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center">
                <h5 class="mb-0">OTP Verification</h5>
            </div>

            <div class="card-body">

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('customer.verify-otp') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $email }}" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">OTP</label>
                        <input type="text" name="otp" class="form-control" placeholder="Enter 6-digit OTP" maxlength="6" required>
                    </div>

                    <button class="btn btn-success w-100" type="submit">Verify OTP</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
