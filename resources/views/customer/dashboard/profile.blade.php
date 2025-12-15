@extends('layouts.app')

@section('title', 'Update Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Update Profile</div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required value="{{ $customer->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required value="{{ $customer->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="">Select</option>
                            <option value="male" {{ $customer->gender=='male'?'selected':'' }}>Male</option>
                            <option value="female" {{ $customer->gender=='female'?'selected':'' }}>Female</option>
                            <option value="other" {{ $customer->gender=='other'?'selected':'' }}>Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required value="{{ $customer->dob }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" required>{{ $customer->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">GST Number (Optional)</label>
                        <input type="text" name="gst_no" class="form-control" value="{{ $customer->gst_no }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Image</label><br>
                        @if ($customer->image)
                            <img src="{{ asset($customer->image) }}" width="80" class="rounded mb-2">
                        @endif
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Save Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
