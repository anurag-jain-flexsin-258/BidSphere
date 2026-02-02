{{--
|--------------------------------------------------------------------------
| Customer Dashboard
|--------------------------------------------------------------------------
| - Overview of customer profile status
| - Clear call-to-action when profile is incomplete
|--------------------------------------------------------------------------
--}}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">

    {{-- Welcome Card --}}
    <div class="col-12">
        <div class="app-card p-4 text-center">
            <h3 class="fw-bold mb-1">
                Welcome, {{ $customer->name ?? 'User' }} 👋
            </h3>

            <p class="text-muted mb-0">
                Manage your profile and tenders from here.
            </p>

            @if (!$customer->profile_completed)
                <div class="alert alert-warning mt-3 mb-0">
                    Your profile is incomplete. Please complete it to continue.
                </div>

                <a href="{{ route('customer.profile.edit') }}"
                   class="btn btn-warning mt-3">
                    Complete Profile
                </a>
            @endif
        </div>
    </div>

    @if ($customer->profile_completed)
        {{-- Profile Details --}}
        <div class="col-md-7">
            <div class="app-card p-4 h-100">
                <h5 class="fw-semibold mb-3">Your Details</h5>

                <ul class="list-unstyled mb-0 text-sm">
                    <li class="mb-2"><strong>Name:</strong> {{ $customer->name }}</li>
                    <li class="mb-2"><strong>Email:</strong> {{ $customer->email }}</li>
                    <li class="mb-2"><strong>Phone:</strong> {{ $customer->phone }}</li>
                    <li class="mb-2"><strong>Gender:</strong> {{ ucfirst($customer->gender) }}</li>
                    <li class="mb-2"><strong>DOB:</strong> {{ $customer->dob }}</li>
                    <li class="mb-2"><strong>Address:</strong> {{ $customer->address }}</li>
                    <li class="mb-2"><strong>GST No:</strong> {{ $customer->gst_no ?? 'N/A' }}</li>
                </ul>

                <a href="{{ route('customer.profile.edit') }}"
                   class="btn btn-outline-primary mt-3">
                    Edit Profile
                </a>
            </div>
        </div>

        {{-- Profile Image --}}
        <div class="col-md-5">
            <div class="app-card p-4 text-center h-100">
                <h5 class="fw-semibold mb-3">Profile Image</h5>

                @if ($customer->image)
                    <img src="{{ asset($customer->image) }}"
                         class="rounded-circle border"
                         width="150" height="150"
                         alt="Profile Image">
                @else
                    <img src="https://via.placeholder.com/150"
                         class="rounded-circle border"
                         alt="Profile Placeholder">
                @endif
            </div>
        </div>
    @endif

</div>
@endsection
