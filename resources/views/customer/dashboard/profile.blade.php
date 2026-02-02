@extends('layouts.app')

@section('title', 'Update Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-8">

        <div class="app-card p-4 p-md-5 shadow-sm">

            {{-- Header --}}
            <h4 class="fw-bold mb-4">Update Profile</h4>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success small">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error Message --}}
            @if($errors->any())
                <div class="alert alert-danger small">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Full Name --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ $customer->name }}">
                </div>

                {{-- Phone --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" required value="{{ $customer->phone }}">
                </div>

                {{-- Gender --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">Gender <span class="text-danger">*</span></label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select</option>
                        <option value="male" {{ $customer->gender=='male'?'selected':'' }}>Male</option>
                        <option value="female" {{ $customer->gender=='female'?'selected':'' }}>Female</option>
                        <option value="other" {{ $customer->gender=='other'?'selected':'' }}>Other</option>
                    </select>
                </div>

                {{-- Date of Birth --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" name="dob" class="form-control" required value="{{ $customer->dob }}">
                </div>

                {{-- Address --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">Address <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control" rows="3" required>{{ $customer->address }}</textarea>
                </div>

                {{-- GST Number --}}
                <div class="mb-3">
                    <label class="form-label fw-medium">GST Number (Optional)</label>
                    <input type="text" name="gst_no" class="form-control" value="{{ $customer->gst_no }}">
                </div>

                {{-- Profile Image --}}
                <div class="mb-4">
                    <label class="form-label fw-medium">Profile Image</label>
                    <div class="d-flex align-items-center gap-3 mt-2">
                        @if ($customer->image)
                            <img src="{{ asset($customer->image) }}" width="80" class="rounded border">
                        @endif
                        <input type="file" name="image" class="form-control flex-grow-1">
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary w-100 py-2">
                    Save Profile
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
