<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends FormRequest
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
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100'
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'عکس الزامی است',
            'avatar.image' => 'فایل باید عکس باشد.',
            'avatar.mimes' => 'فرمت مورد قبول: jpeg, png, jpg, gif.',
            'avatar.max' => 'عکس نباید بیشتر از 2MB باشد.',
            'avatar.dimensions' => 'اندازه عکس حداقل 100x100 باشد.',
        ];
    }
}
