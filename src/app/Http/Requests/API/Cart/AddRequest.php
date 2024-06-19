<?php

namespace App\Http\Requests\API\Cart;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'packages' => ['required','array'],
            'packages.*.product_id' => ['required','exists:products,id']
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'The product_id field is required.',
            'product_id.exists' => 'The selected product_id is invalid.',
            'packages.required' => 'انتخاب دوره در پکیج الزامی است',
            'packages.array' => 'The packages must be an array.',
            'packages.*.product_id.required' => 'هر پکیج باید شامل محصول باشد.',
            'packages.*.product_id.exists' => 'محصول انتخاب شده موجود نیست.',
        ];
    }
}
