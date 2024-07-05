<?php

namespace App\Http\Requests\Course;

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
            'product_type_id'           => ['required'],
            'user_id'                   => ['required'],
            'name'                      => ['required'],
            'original_price'            => ['nullable', 'numeric'],
            'off_price'                 => ['nullable', 'numeric'],
            'options'                   => ['nullable'],
            'sort_num'                  => ['nullable', 'numeric'],
            'img_filename'              => ['nullable'],
            'subscription_start_at'     => ['nullable'],
            'has_installment'           => ['sometimes', 'required'],
            'installment_count'         => ['required_if:has_installment,1', 'nullable', 'numeric'],
            'first_installment_ratio' => ['nullable'],
            'first_installment_amount' => ['nullable'],
            'final_installment_date'    => ['required_if:has_installment,1'],
            'expiration_duration'       => ['nullable'],
            'start_date'                => ['required'],
            'description'               => ['required'],
            'about_course'              => ['required'],
            'is_purchasable'            => ['sometimes', 'required'],
            'show_in_list'              => ['sometimes', 'required'],
            'qa_status'                 => ['sometimes', 'required'],
            'categories'                => ['array'],
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'original_price' => str_replace(',', '', $this->original_price),
            'off_price' => str_replace(',', '', $this->off_price),
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
                    $validator->errors()->add('first_installment_amount', 'برای دوره اقساطی پر کردن میزان پرداختی اولیه به صورت قسط یا نقدی الزامی است.');
                } elseif (!empty($firstInstallmentRatio) && !empty($firstInstallmentAmount)) {
                    $validator->errors()->add('first_installment_ratio', 'انتخاب همزمان پرداخت اولیه به صورت نقدی و اقساطی مجاز نیست');
                    $validator->errors()->add('first_installment_amount', 'انتخاب همزمان پرداخت اولیه به صورت نقدی و اقساطی مجاز نیست');
                }
            }
        });
    }
}
