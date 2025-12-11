@extends('layouts.app')

@section('title', 'Customer Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Customer Login</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('customer.login') }}">
            @csrf
            <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <button class="btn btn-primary w-100" type="submit">Send OTP</button>
        </form>
    </div>
</div>
@endsection
