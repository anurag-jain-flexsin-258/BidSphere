@extends('layouts.app')

@section('title', 'Customer Registration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Customer Registration</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('customer.register') }}" enctype="multipart/form-data">
            @csrf
            <input class="form-control mb-2" type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
            <input class="form-control mb-2" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input class="form-control mb-2" type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>

            <select class="form-control mb-2" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
            </select>

            <input class="form-control mb-2" type="date" name="dob" value="{{ old('dob') }}" required>
            <input class="form-control mb-2" type="text" name="address" placeholder="Address" value="{{ old('address') }}" required id="address">
            <input class="form-control mb-2" type="text" name="gst_no" placeholder="GST No (optional)" value="{{ old('gst_no') }}">
            <input class="form-control mb-2" type="file" name="image">

            <button class="btn btn-primary w-100" type="submit">Register</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const input = document.getElementById('address');
    const autocomplete = new google.maps.places.Autocomplete(input);
</script>
@endpush
