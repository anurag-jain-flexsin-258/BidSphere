@extends('layouts.app')
@section('title', 'Create Tender')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- Card Wrapper --}}
        <div class="app-card p-4 p-md-5 shadow-sm rounded">

            {{-- Header --}}
            <div class="d-flex flex-row flex-wrap justify-content-between align-items-center mb-4 gap-3">

                {{-- Title + Subtitle --}}
                <div class="me-3">
                    <h2 class="fw-bold mb-3">Create New Tender</h2>
                    <p class="text-muted small mb-4">
                        Fill in the details below to create a new tender.
                    </p>
                </div>

                {{-- Back to Tender Button --}}
                <div class="mt-4">
                    <a href="{{ route('customer.tenders.index') }}" class="btn btn-outline-secondary">
                        Back to Tenders
                    </a>
                </div>

            </div>

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
            <form action="{{ route('customer.tenders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('customer.tenders._form', [
                    'categories' => $categories,
                    'buttonText' => 'Create Tender'
                ])
            </form>



        </div>
    </div>
@endsection
