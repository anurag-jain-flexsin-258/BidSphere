@extends('layouts.app')
@section('title', 'My Tenders')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h2 class="fw-bold mb-1">My Tenders</h2>
            <p class="text-muted small">Manage and track all your tenders</p>
        </div>

        <a href="{{ route('customer.tenders.create') }}"
           class="btn btn-primary d-inline-flex align-items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Create Tender
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
                                <a href="{{ route('customer.tenders.show', $tender) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    View
                                </a>
                                <a href="{{ route('customer.tenders.edit', $tender) }}"
                                   class="btn btn-outline-warning btn-sm">
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
            <svg class="mx-auto h-12 w-12 text-muted" fill="none"
                 stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125V5.625A3.375 3.375 0 009.375 2.25H4.875A3.375 3.375 0 001.5 5.625v12.75A3.375 3.375 0 004.875 21.75h9.75A3.375 3.375 0 0018 18.375v-1.5"/>
            </svg>

            <h3 class="fw-bold mt-4">No tenders yet</h3>
            <p class="text-muted small">Create your first tender to get started.</p>

            <a href="{{ route('customer.tenders.create') }}"
               class="btn btn-primary mt-3">
                Create Tender
            </a>
        </div>
    @endif

</div>
@endsection
