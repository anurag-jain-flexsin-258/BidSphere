@extends('layouts.app')
@section('title', 'My Tenders')

@section('content')
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="d-flex flex-row flex-wrap justify-content-between align-items-center mb-4 gap-3">

            {{-- Title + Subtitle --}}
            <div class="me-3">
                <h2 class="fw-bold mb-1">My Tenders</h2>
                <p class="text-muted small mb-0">Manage and track all your tenders</p>
            </div>

            {{-- Create Tender Button --}}
            <a href="{{ route('customer.tenders.create') }}" class="btn btn-primary d-flex align-items-center flex-nowrap">
                {{-- Scaled SVG icon --}}
                <svg width="24" height="24" viewBox="0 0 8 8" fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" class="me-2">
                    <path d="M3 0v6M0 3h6" />
                </svg>

                {{-- Text fully in one row --}}
                <span class="fw-semibold text-nowrap">Create Tenders</span>
            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success small mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tender Table or Empty State --}}
        @if($tenders->count())
            <div class="table-responsive bg-white shadow-sm rounded border">
                <table class="table table-hover mb-0">
                    <thead class="table-light text-uppercase text-muted small">
                        <tr>
                            <th>Title</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Expires</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tenders as $tender)
                            @php
                                $statusColors = [
                                    'open' => 'bg-success text-white',
                                    'closed' => 'bg-secondary text-white',
                                    'draft' => 'bg-warning text-dark',
                                ];
                            @endphp
                            <tr>
                                <td>{{ $tender->title }}</td>
                                <td>{{ $tender->quantity }}</td>
                                <td>
                                    <span class="badge {{ $statusColors[$tender->status] ?? 'bg-primary text-white' }}">
                                        {{ ucfirst($tender->status) }}
                                    </span>
                                </td>
                                <td>{{ $tender->expires_at?->format('d M Y') ?? '—' }}</td>
                                <td class="text-end d-flex gap-2 justify-content-end">
                                    <a href="{{ route('customer.tenders.show', $tender) }}" class="btn btn-outline-primary btn-sm">
                                        View
                                    </a>
                                    <a href="{{ route('customer.tenders.edit', $tender) }}" class="btn btn-outline-warning btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('customer.tenders.destroy', $tender) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete tender?')"
                                            class="btn btn-outline-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="p-3">
                    {{ $tenders->links() }}
                </div>
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-16">
                <h3 class="fw-bold mt-4">No tenders yet</h3>
                <p class="text-muted small">Create your first tender to get started.</p>

                <a href="{{ route('customer.tenders.create') }}" class="btn btn-primary mt-3">
                    Create Tender
                </a>
            </div>
        @endif

    </div>
@endsection