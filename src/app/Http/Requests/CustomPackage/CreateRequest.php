<?php

namespace App\Http\Requests\CustomPackage;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'subscription_start_at' => ['nullable', 'string'],
            'off_price' => ['nullable', 'numeric'],
            'description' => ['required', 'string'],
            'options' => ['array'],
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
            'img_filename' => [ 'image']
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'original_price' => str_replace(',', '', $this->original_price),
            'off_price' => str_replace(',', '', $this->off_price),
            'sections' => array_map(fn($sec) => json_decode($sec, true), $this->sections)
        ]);
    }
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('has_installment') == 1) {
                $firstInstallmentRatio = $this->input('first_installment_ratio');
                $firstInstallmentAmount = $this->input('first_installment_amount');

                if (empty($firstInstallmentRatio) && empty($firstInstallmentAmount)) {
                    $validator->errors()->add('first_installment_ratio', 'برای دوره اقساطی پر کردن میزان پرداختی اولیه به صورت قسط یا نقدی الزامی است.');
//                    $validator->errors()->add('first_installment_amount', 'برای دوره اقساطی پر کردن میزان پرداختی اولیه به صورت قسط یا نقدی الزامی است.');
                } elseif (!empty($firstInstallmentRatio) && !empty($firstInstallmentAmount)) {
                    $validator->errors()->add('first_installment_ratio', 'انتخاب همزمان پرداخت اولیه به صورت نقدی و اقساطی مجاز نیست');
//                    $validator->errors()->add('first_installment_amount', 'انتخاب همزمان پرداخت اولیه به صورت نقدی و اقساطی مجاز نیست');
                }
            }
        });
    }

    public function messages()
    {
        return [
          'user_id.required' => 'انتخاب استاد الزامی است.'
        ];
    }
}
