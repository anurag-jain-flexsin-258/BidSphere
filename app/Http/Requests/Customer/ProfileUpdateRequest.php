<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'gender'  => 'required|in:male,female,other',
            'dob'     => 'required|date',
            'address' => 'required|string',
            'gst_no'  => 'nullable|string|max:50',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
