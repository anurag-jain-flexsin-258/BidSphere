@extends('layouts.app')
@section('title', $tender->title)

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Card Wrapper --}}
    <div class="app-card p-4 p-md-5 shadow-sm rounded">

        {{-- Header --}}
        <h2 class="fw-bold mb-3">{{ $tender->title }}</h2>
        <p class="text-muted small mb-4">Details of your tender</p>

        {{-- Basic Info --}}
        <ul class="list-unstyled mb-4 text-sm">
            <li class="mb-2"><strong>Description:</strong> {{ $tender->description ?? '-' }}</li>
            <li class="mb-2"><strong>Quantity:</strong> {{ $tender->quantity }}</li>
            <li class="mb-2"><strong>Status:</strong> {{ ucfirst($tender->status) }}</li>
            <li class="mb-2"><strong>Expires At:</strong> {{ $tender->expires_at?->format('Y-m-d') ?? '-' }}</li>
            <li class="mb-2"><strong>Featured:</strong> {{ $tender->is_featured ? 'Yes' : 'No' }}</li>
        </ul>

        {{-- Categories --}}
        @if($tender->categories->count())
            <div class="mb-4">
                <strong>Categories:</strong>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    @foreach($tender->categories as $category)
                        <span class="badge bg-secondary">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Images --}}
        @if($tender->images->count())
            <div class="mb-4">
                <strong>Images:</strong>
                <div class="row g-2 mt-2">
                    @foreach($tender->images as $image)
                        <div class="col-4 col-md-3">
                            <img src="{{ asset("storage/tenders/images/tender_{$tender->id}/{$image->image}") }}"
                                 class="img-fluid rounded shadow-sm"
                                 alt="Tender Image">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Attachments --}}
        @if($tender->attachments->count())
            <div class="mb-4">
                <strong>Attachments:</strong>
                <ul class="list-group list-group-flush mt-2 small">
                    @foreach($tender->attachments as $attachment)
                        <li class="list-group-item p-1">
                            <a href="{{ asset("storage/tenders/attachments/tender_{$tender->id}/{$attachment->file_path}") }}"
                               target="_blank" class="text-primary">
                                {{ $attachment->original_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Back Button --}}
        <div class="mt-4">
            <a href="{{ route('customer.tenders.index') }}"
               class="btn btn-outline-secondary">
                Back to Tenders
            </a>
        </div>

    </div>
</div>
@endsection
