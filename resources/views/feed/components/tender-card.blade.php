@php
    $image = $tender->images->first();
@endphp

<div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden">

    {{-- Background Image --}}
    @if($image)
        <div class="position-relative" style="height: 300px; overflow:hidden;">
            <img src="{{ asset('storage/tenders/images/tender_'.$tender->id.'/'.$image->image) }}"
                 class="w-100 h-100 object-fit-cover"
                 alt="{{ $tender->title }}">
        </div>
    @endif

    <div class="card-body">

        {{-- Title --}}
        <h5 class="fw-bold">
            <a href="{{ route('feed.show', $tender) }}" class="text-dark text-decoration-none">
                {{ $tender->title }}
            </a>
        </h5>

        {{-- Meta Info --}}
        <div class="text-muted small mb-2">
            Posted by {{ $tender->customer->name }}
            • {{ $tender->approved_at?->diffForHumans() }}
        </div>

        {{-- Description --}}
        @unless(isset($single) && $single)
            <p class="mb-3">{{ Str::limit($tender->description, 200) }}</p>
        @endunless

        {{-- Stats --}}
        <div class="d-flex justify-content-between text-muted small mb-3">
            <span>👁 {{ $tender->views_count }} views</span>
            <span>👍 {{ $tender->likes_count }} likes</span>
            <span>Qty: {{ $tender->quantity }}</span>
        </div>

        {{-- Actions --}}
        @include('feed.components.tender-actions', ['tender' => $tender])

    </div>
</div>