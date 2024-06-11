<?php

namespace App\Http\Requests\CustomPackage;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomPackageRequest extends FormRequest
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
            'original_price' => ['required', 'numeric'],
            'holding_date' => ['nullable', 'string'],
            'off_price' => ['nullable', 'numeric'],
            'description' => ['required', 'string'],
            'options' => ['array'],
            'options.fake_price' => ['nullable', 'numeric'],
            'options.full_price_show' => ['nullable', 'numeric'],
            'name' => ['required', 'max:255'],
            'is_purchasable' => ['nullable', 'boolean'],
            'has_installment' => ['nullable', 'boolean'],
            'show_in_list' => ['nullable', 'boolean'],
            'installment_count' => ['nullable', 'integer'],
            'first_installment_ratio' => ['nullable', 'integer'],
            'first_installment_amount' => ['nullable', 'numeric'],
            'final_installment_date' => ['nullable', 'string'],
            'sections' => ['required','array'],
            'sections.*.id' => ['required','integer'],
            'sections.*.title' => ['required','string'],
            'sections.*.courses.*.id' => ['required','exists:products,id'],
            'sections.*.courses.*.name' => ['required','string'],
            'img_filename' => ['required', 'image']
        ];
    }
}
