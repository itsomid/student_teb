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
    protected function prepareForValidation(): void
    {
        $this->merge([
            'sections' => array_map(fn($sec) => json_decode($sec, true), $this->sections)
        ]);
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
            'is_purchasable' => ['nullable'],
            'has_installment' => ['nullable'],
            'show_in_list' => ['nullable'],
            'installment_count' => ['nullable', 'integer'],
            'first_installment_ratio' => ['nullable', 'integer'],
            'first_installment_amount' => ['nullable', 'numeric'],
            'final_installment_date' => ['nullable', 'string'],
            'sections' => ['required', 'array'],
            'sections.*.id' => ['required', 'integer'],
            'sections.*.title' => ['required', 'string'],
            'sections.*.courses' => ['required', 'array'],
            'sections.*.courses.*.id' => ['required', 'integer', 'exists:products,id'],
            'sections.*.courses.*.name' => ['required', 'string'],
            'sections.*.courses.*.image_src' => ['sometimes', 'string'],
            'img_filename' => ['nullable', 'image']
        ];
    }
}
