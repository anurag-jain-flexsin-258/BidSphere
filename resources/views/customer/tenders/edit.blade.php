@extends('layouts.app')
@section('title', 'Edit Tender')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Card Wrapper --}}
    <div class="app-card p-4 p-md-5 shadow-sm rounded">

        {{-- Header --}}
        <h2 class="fw-bold mb-3">Edit Tender</h2>
        <p class="text-muted small mb-4">
            Update the details below for this tender.
        </p>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger small mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('customer.tenders.update', $tender) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('customer.tenders._form', [
                'tender' => $tender,
                'categories' => $categories,
                'buttonText' => 'Update Tender'
            ])
        </form>

    </div>
</div>
@endsection
