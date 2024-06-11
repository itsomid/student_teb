<?php

namespace App\Http\Requests\CustomPackage;

use Illuminate\Foundation\Http\FormRequest;

class EditCustomPackageRequest extends FormRequest
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
            'user_id' => ['required', 'exists:admins,id'],
            'original_price' => ['required'],
            'name' => ['required'],
            'sections' => ['required','array'],
            'img_filename' => ['nullable', 'image']
        ];
    }
}
