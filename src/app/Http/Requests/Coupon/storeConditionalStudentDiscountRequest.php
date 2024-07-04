<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class storeConditionalStudentDiscountRequest extends FormRequest
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
        if (!$this->filled('discount_percentage') && !$this->filled('discount_amount')) {

            $error= [
                'discount_percentage'=> 'مقدار درصدی یا مبلغ ثابت باید تعیین شوند',
                'discount_amount'=> 'مقدار درصدی یا مبلغ ثابت باید تعیین شوند',
            ];
            throw \Illuminate\Validation\ValidationException::withMessages($error);
        }

        if ($this->filled('discount_percentage') && $this->filled('discount_amount')) {
            $error= [
                'discount_percentage'=> 'مقدار درصدی و مبلغ ثابت همزمان نمی توانند اعمال شوند',
                'discount_amount'=> 'مقدار درصدی و مبلغ ثابت همزمان نمی توانند اعمال شوند',
            ];
            throw \Illuminate\Validation\ValidationException::withMessages($error);
        }

        return [
            'coupon'                => ['required'],
            'consumer_ids'          => ['required'],
            'description'           => ['nullable', 'max:254'],
            'discount_percentage'   => ['nullable', 'numeric', 'required_without:discount_amount'],
            'discount_amount'       => ['nullable', 'numeric', 'required_without:discount_percentage'],
            'expired_at'            => ['nullable', 'date'],
            'product_ids'           => ['required', 'array'],
            'is_one_time'           => ['required', 'boolean'],
        ];
    }
}
