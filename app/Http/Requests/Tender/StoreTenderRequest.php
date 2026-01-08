<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'quantity' => 'required|integer|min:1',
            'status' => 'nullable|in:pending,approved,rejected,closed',
            'expires_at' => 'nullable|date|after_or_equal:today',
            'is_featured' => 'nullable|boolean',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'file|image|max:5120', 
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', 
        ];
    }
}
