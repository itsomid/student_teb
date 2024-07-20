<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'new_password' => [
                'required',
                'string',
                'min:8', // Minimum length
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one digit
                'not_in:123456,12345678,password,admin', // Disallowed common passwords
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'new_password.regex' => 'رمز عبور حداقل باید شامل یک حرف بزرگ٬ کوچک و یک عدد باشد.',
            'new_password.not_in' => 'رمز عبور نمی‌تواند شامل کلمه های پر استفاده باشد.',
            'new_password_confirmation.same' => 'رمز عبور با تکرار آن مطابقت ندارد.'

        ];
    }
}
