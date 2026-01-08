@extends('layouts.app')
@section('title', $tender->title)

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">{{ $tender->title }}</h1>

    <p><strong>Description:</strong> {{ $tender->description }}</p>
    <p><strong>Quantity:</strong> {{ $tender->quantity }}</p>
    <p><strong>Status:</strong> {{ ucfirst($tender->status) }}</p>
    <p><strong>Expires At:</strong> {{ $tender->expires_at?->format('Y-m-d') ?? '-' }}</p>
    <p><strong>Featured:</strong> {{ $tender->is_featured ? 'Yes' : 'No' }}</p>

    {{-- Categories --}}
    <p><strong>Categories:</strong>
        @foreach($tender->categories as $category)
            <span class="inline-block bg-gray-200 rounded px-2 py-1 mr-2">{{ $category->name }}</span>
        @endforeach
    </p>

    {{-- Images --}}
    @if($tender->images->count())
        <div class="mt-4">
            <strong>Images:</strong>
            <div class="grid grid-cols-3 gap-4 mt-2">
                @foreach($tender->images as $image)
                    <img src="{{ asset("storage/tenders/images/tender_{$tender->id}/{$image->image}") }}" alt="Image" class="w-full h-32 object-cover rounded">
                @endforeach
            </div>
        </div>
    @endif

    {{-- Attachments --}}
    @if($tender->attachments->count())
        <div class="mt-4">
            <strong>Attachments:</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach($tender->attachments as $attachment)
                    <li><a href="{{ asset("storage/tenders/attachments/tender_{$tender->id}/{$attachment->file_path}") }}" class="text-blue-600" target="_blank">{{ $attachment->original_name }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('customer.tenders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to Tenders</a>
    </div>
</div>
@endsection
