@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="app-card p-4 p-md-5 shadow-sm">

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

                <form action="{{ route('customer.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- LEFT SIDE : PROFILE IMAGE --}}
                        <div class="col-md-4 text-center mb-4 mb-md-0">

                            <img
                                src="{{ $customer->image ? asset($customer->image) : 'https://via.placeholder.com/150' }}"
                                alt="Profile Image"
                                class="rounded-circle border shadow-sm"
                                width="160"
                                height="160"
                                style="object-fit: cover;"
                            >

                            <div class="mt-3">
                                <input type="file"
                                       name="image"
                                       class="form-control form-control-sm">
                            </div>

                        </div>

                        {{-- RIGHT SIDE : PROFILE DETAILS --}}
                        <div class="col-md-8">

                            {{-- Name as Heading (No Label) --}}
                            <input type="text"
                                   name="name"
                                   class="form-control border-0 fs-3 fw-bold px-0 mb-3"
                                   value="{{ $customer->name }}"
                                   placeholder="Full Name"
                                   required>

                            <hr>

                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    Phone Number
                                </label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ $customer->phone }}"
                                       required>
                            </div>

                            {{-- Gender --}}
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    Gender
                                </label>
                                <select name="gender"
                                        class="form-select"
                                        required>
                                    <option value="">Select</option>
                                    <option value="male" {{ $customer->gender=='male'?'selected':'' }}>Male</option>
                                    <option value="female" {{ $customer->gender=='female'?'selected':'' }}>Female</option>
                                    <option value="other" {{ $customer->gender=='other'?'selected':'' }}>Other</option>
                                </select>
                            </div>

                            {{-- Date of Birth --}}
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    Date of Birth
                                </label>
                                <input type="date"
                                       name="dob"
                                       class="form-control"
                                       value="{{ $customer->dob }}"
                                       required>
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label class="form-label fw-medium">
                                    Address
                                </label>
                                <textarea name="address"
                                          class="form-control"
                                          rows="3"
                                          required>{{ $customer->address }}</textarea>
                            </div>

                            {{-- GST --}}
                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    GST Number (Optional)
                                </label>
                                <input type="text"
                                       name="gst_no"
                                       class="form-control"
                                       value="{{ $customer->gst_no }}">
                            </div>

                            {{-- Save Button --}}
                            <div class="text-end">
                                <button type="submit"
                                        class="btn btn-primary px-4">
                                    Save Changes
                                </button>
                            </div>

                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection