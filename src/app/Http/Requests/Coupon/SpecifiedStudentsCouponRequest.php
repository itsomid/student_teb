<?php

namespace App\Http\Requests\Coupon;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpecifiedStudentsCouponRequest extends FormRequest
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
            'discount_amount' =>  !is_null($this->discount_amount) ? str_replace(',', '', $this->discount_amount) : null
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
            'coupon_name'           => ['required','max:20', Rule::unique('coupons', 'coupon_name')->ignore($this->route('coupon'))],
            'consumer_ids'          => ['required'],
            'description'           => ['nullable', 'max:254'],
            'discount_percentage'   => ['nullable', 'numeric', 'required_without:discount_amount'],
            'discount_amount'       => ['nullable', 'numeric', 'required_without:discount_percentage'],
            'expired_at'            => ['nullable', 'date'],
            'product_ids'           => ['nullable', 'array'],
            'is_one_time'           => ['required', 'boolean'],
        ];
    }
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->filled('discount_percentage') && !$this->filled('discount_amount')) {

                $validator->errors()->add('first_installment_ratio', 'مقدار درصدی یا مبلغ ثابت باید تعیین شوند.');
            }

            if ($this->filled('discount_percentage') && $this->filled('discount_amount')) {

                $validator->errors()->add('first_installment_ratio', 'مقدار درصدی و مبلغ ثابت همزمان نمی توانند اعمال شوند.');
            }
        });
    }


}
