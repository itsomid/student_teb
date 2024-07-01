<?php

namespace App\Http\Requests\Coupon;

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
            'consumer_user_id'                  => ['required'],
            'specific_product_id'               => ['required'],
            'discount_percentage'               => ['nullable', 'numeric', 'required_without:discount_amount'],
            'discount_amount'                   => ['nullable', 'numeric', 'required_without:discount_percentage'],
            'for_old_users'                     => ['nullable', 'boolean'],
            'for_old_users_min_pay'             => ['required', 'required_if:for_old_users,1'],
            'coupon'                            => ['nullable'],
            'expired_at'                        => ['nullable', 'date'],
            'coupon_count'                      => ['nullable', 'numeric'],
            'product_atleast_count'             => ['nullable', 'numeric'],
            'product_atleast_one'               => ['nullable', 'in:0,1'],
            'product_bought_atleast_count'      => ['nullable', 'numeric'],
            'conditions_products_ids'           => ['nullable', 'array'],
            'conditions_products_bought_ids'    => ['nullable', 'array'],
            'conditions_profile'                => ['nullable', 'array'],
            'is_multiuser'                      => ['nullable', 'boolean'],
            'is_disposable'                     => ['nullable', 'boolean'],
            'has_purchased'                     => ['nullable', 'in:0,1,2'],
            'description'                       => ['nullable']
        ];
    }
}
