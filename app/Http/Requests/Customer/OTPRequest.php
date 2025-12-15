<?php 
namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class OTPRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ];
    }

    /**
     * Preserve email even if validation fails
     */
    protected function failedValidation(Validator $validator)
    {
        $response = redirect()
            ->back()
            ->withErrors($validator)
            ->withInput($this->except('otp')) // keep all except OTP
            ->with('email', $this->email);    // explicitly flash email

        throw new ValidationException($validator, $response);
    }
}
