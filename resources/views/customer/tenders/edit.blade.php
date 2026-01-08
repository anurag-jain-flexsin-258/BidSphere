@extends('layouts.app')
@section('title', 'Edit Tender')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-6">Edit Tender</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
@endsection
