@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h3>Welcome, {{ $customer->name ?? 'User' }} 👋</h3>

                @if (!$customer->profile_completed)
                    <p class="text-danger mt-2">Your profile is incomplete. Please update it.</p>
                    <a href="{{ route('customer.profile.edit') }}" class="btn btn-warning mt-2">Complete Profile</a>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($customer->profile_completed)
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">Your Details</div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($customer->gender) }}</p>
                <p><strong>DOB:</strong> {{ $customer->dob }}</p>
                <p><strong>Address:</strong> {{ $customer->address }}</p>
                <p><strong>GST No:</strong> {{ $customer->gst_no ?? 'N/A' }}</p>

                <a href="{{ route('customer.profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">Profile Image</div>
            <div class="card-body text-center">
                @if ($customer->image)
                    <img src="{{ asset($customer->image) }}" width="150" height="150" class="rounded-circle border">
                @else
                    <img src="https://via.placeholder.com/150" class="rounded-circle border">
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection
