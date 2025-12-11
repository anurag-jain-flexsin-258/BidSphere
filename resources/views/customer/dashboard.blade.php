@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h3>Welcome, {{ auth()->guard('customer')->user()->name }}</h3>
            <hr>
            <p><strong>Email:</strong> {{ auth()->guard('customer')->user()->email }}</p>
            <p><strong>Phone:</strong> {{ auth()->guard('customer')->user()->phone }}</p>
            <p><strong>Gender:</strong> {{ ucfirst(auth()->guard('customer')->user()->gender) }}</p>
            <p><strong>Date of Birth:</strong> {{ auth()->guard('customer')->user()->dob }}</p>
            <p><strong>Address:</strong> {{ auth()->guard('customer')->user()->address }}</p>
            @if(auth()->guard('customer')->user()->gst_no)
                <p><strong>GST No:</strong> {{ auth()->guard('customer')->user()->gst_no }}</p>
            @endif
            @if(auth()->guard('customer')->user()->image)
                <img src="{{ asset('storage/' . auth()->guard('customer')->user()->image) }}" alt="Profile Image" class="img-thumbnail" width="150">
            @endif
        </div>
    </div>
</div>
@endsection
