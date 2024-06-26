<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'name_english' => ['required', 'string', 'max:255'],
            'province' => ['required', 'int', 'gt:0'],
            'city' => ['required', 'int', 'gt:0'],
            'grade' => ['required'],
            'sex' => ['required', 'int'],
            'field_of_study' => ['required'],
            'familiarity_way' => ['required', 'not_in:0'],
        ];
    }
}
