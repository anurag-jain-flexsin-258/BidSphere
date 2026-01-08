@extends('layouts.app')
@section('title', 'My Tenders')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-6">My Tenders</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('customer.tenders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Create New Tender
        </a>
    </div>

    @if($tenders->count())
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Quantity</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Expires</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenders as $tender)
                    <tr>
                        <td class="border px-4 py-2">{{ $tender->title }}</td>
                        <td class="border px-4 py-2">{{ $tender->quantity }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($tender->status) }}</td>
                        <td class="border px-4 py-2">{{ $tender->expires_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <a href="{{ route('customer.tenders.show', $tender) }}" class="text-blue-600">View</a>
                            <a href="{{ route('customer.tenders.edit', $tender) }}" class="text-yellow-600">Edit</a>
                            <form action="{{ route('customer.tenders.destroy', $tender) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600" onclick="return confirm('Delete tender?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $tenders->links() }}</div>
    @else
        <p>No tenders found.</p>
    @endif
</div>
@endsection
