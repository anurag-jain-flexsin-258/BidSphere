{{-- resources/views/welcome.blade.php --}}

@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="text-center mt-5">
        <h1>Welcome to Bidsphere</h1>
        <p class="lead">Get started by logging in or registering below.</p>

        <div class="mt-4">
            <a href="{{ route('customer.login') }}" class="btn btn-primary me-2">Login</a>
            <a href="{{ route('customer.register') }}" class="btn btn-secondary">Register</a>
        </div>
    </div>
@endsection