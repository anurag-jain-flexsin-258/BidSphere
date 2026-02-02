@foreach ($categories as $category)
    <div class="form-check mb-1" style="margin-left: {{ $level * 20 }}px;">
        <input
            class="form-check-input"
            type="checkbox"
            name="categories[]"
            value="{{ $category->id }}"
            {{ in_array($category->id, $selected) ? 'checked' : '' }}
        >
        <label class="form-check-label">
            {{ $category->name }}
        </label>
    </div>

    @if ($category->children->count())
        <x-category-tree
            :categories="$category->children"
            :selected="$selected"
            :level="$level + 1"
        />
    @endif
@endforeach
