{{-- resources/views/customer/tenders/_form.blade.php --}}
@props(['tender' => null, 'categories'])

<div class="mb-4">
    <label for="title" class="block font-medium mb-1">Title <span class="text-red-500">*</span></label>
    <input type="text" name="title" id="title" value="{{ old('title', $tender->title ?? '') }}"
           class="w-full border rounded px-3 py-2" required>
</div>

<div class="mb-4">
    <label for="description" class="block font-medium mb-1">Description</label>
    <textarea name="description" id="description" rows="5"
              class="w-full border rounded px-3 py-2">{{ old('description', $tender->description ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="quantity" class="block font-medium mb-1">Quantity <span class="text-red-500">*</span></label>
    <input type="number" name="quantity" id="quantity"
           value="{{ old('quantity', $tender->quantity ?? '') }}"
           class="w-full border rounded px-3 py-2" min="1" required>
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">Categories</label>
    <div class="grid grid-cols-2 gap-2">
        @foreach ($categories as $category)
            <label class="inline-flex items-center">
                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                       class="form-checkbox"
                       {{ in_array($category->id, old('categories', $tender->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                <span class="ml-2">{{ $category->name }}</span>
            </label>
        @endforeach
    </div>
</div>

<div class="mb-4">
    <label for="images" class="block font-medium mb-1">Images</label>
    <input type="file" name="images[]" id="images" multiple accept="image/*" class="w-full border rounded px-3 py-2">
    @if($tender && $tender->images->count())
        <div class="grid grid-cols-3 gap-4 mt-2">
            @foreach($tender->images as $image)
                <img src="{{ asset("storage/tenders/images/tender_{$tender->id}/{$image->image}") }}" class="w-full h-32 object-cover rounded">
            @endforeach
        </div>
    @endif
</div>

<div class="mb-4">
    <label for="attachments" class="block font-medium mb-1">Attachments</label>
    <input type="file" name="attachments[]" id="attachments" multiple class="w-full border rounded px-3 py-2">
    @if($tender && $tender->attachments->count())
        <ul class="list-disc pl-5 mt-2">
            @foreach($tender->attachments as $attachment)
                <li>
                    <a href="{{ asset("storage/tenders/attachments/tender_{$tender->id}/{$attachment->file_path}") }}"
                       target="_blank" class="text-blue-600">
                        {{ $attachment->original_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<div class="mb-4">
    <label for="expires_at" class="block font-medium mb-1">Expires At</label>
    <input type="date" name="expires_at" id="expires_at"
           value="{{ old('expires_at', $tender->expires_at?->format('Y-m-d') ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="mb-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="is_featured" value="1" class="form-checkbox"
               {{ old('is_featured', $tender->is_featured ?? false) ? 'checked' : '' }}>
        <span class="ml-2">Mark as Featured</span>
    </label>
</div>

<div class="mt-6">
    <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        {{ $buttonText ?? 'Save Tender' }}
    </button>
</div>
