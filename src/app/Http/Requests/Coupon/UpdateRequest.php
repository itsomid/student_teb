<?php

namespace App\Http\Requests\Coupon;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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


        if (auth('admin')->user()->cannot('coupons.coupons.all.data')) {
            if ($this->discount_percentage < Coupon::getDiscountRange()->min || $this->discount_percentage > Coupon::getDiscountRange()->max)
            {
                $minDiscount = Coupon::getDiscountRange()->min;
                $maxDiscount = Coupon::getDiscountRange()->max;

                $error= ['discount_percentage'=> "درصد تخفیف حداقل باید $minDiscount درصد و حداکثر باید $maxDiscount درصد باشد"];
                throw \Illuminate\Validation\ValidationException::withMessages($error);
            }
        }

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
