{{-- resources/views/customer/tenders/_form.blade.php --}}
@props(['tender' => null, 'categories'])

<div class="row g-3">

    {{-- Title --}}
    <div class="col-12">
        <label for="title" class="form-label fw-medium">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" value="{{ old('title', $tender->title ?? '') }}"
               class="form-control" required>
    </div>

    {{-- Description --}}
    <div class="col-12">
        <label for="description" class="form-label fw-medium">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="form-control">{{ old('description', $tender->description ?? '') }}</textarea>
    </div>

    {{-- Quantity --}}
    <div class="col-md-6">
        <label for="quantity" class="form-label fw-medium">Quantity <span class="text-danger">*</span></label>
        <input type="number" name="quantity" id="quantity"
               value="{{ old('quantity', $tender->quantity ?? '') }}"
               class="form-control" min="1" required>
    </div>

    {{-- Expires At --}}
    <div class="col-md-6">
        <label for="expires_at" class="form-label fw-medium">Expires At</label>
        <input type="date" name="expires_at" id="expires_at"
               value="{{ old('expires_at', $tender->expires_at?->format('Y-m-d') ?? '') }}"
               class="form-control">
    </div>

    {{-- Categories --}}
    <div class="col-12">
        <label class="form-label fw-medium">Categories</label>
        <div class="d-flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="categories[]"
                           value="{{ $category->id }}"
                           id="category_{{ $category->id }}"
                           {{ in_array($category->id, old('categories', $tender->categories->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category_{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Images --}}
    <div class="col-12">
        <label for="images" class="form-label fw-medium">Images</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*" class="form-control">
        @if($tender && $tender->images->count())
            <div class="row mt-2 g-2">
                @foreach($tender->images as $image)
                    <div class="col-4">
                        <img src="{{ asset("storage/tenders/images/tender_{$tender->id}/{$image->image}") }}"
                             class="img-fluid rounded shadow-sm">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Attachments --}}
    <div class="col-12">
        <label for="attachments" class="form-label fw-medium">Attachments</label>
        <input type="file" name="attachments[]" id="attachments" multiple class="form-control">
        @if($tender && $tender->attachments->count())
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
        @endif
    </div>

    {{-- Featured --}}
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                   id="is_featured" {{ old('is_featured', $tender->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">
                Mark as Featured
            </label>
        </div>
    </div>

    {{-- Submit Button --}}
    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary w-100">
            {{ $buttonText ?? 'Save Tender' }}
        </button>
    </div>

</div>
