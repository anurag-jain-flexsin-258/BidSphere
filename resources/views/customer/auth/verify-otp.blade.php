@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Enter OTP</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('customer.verify.otp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <input class="form-control mb-2" type="text" name="otp" placeholder="6-digit OTP" required>
            <button class="btn btn-primary w-100" type="submit">Verify OTP</button>
        </form>
    </div>
</div>
@endsection
