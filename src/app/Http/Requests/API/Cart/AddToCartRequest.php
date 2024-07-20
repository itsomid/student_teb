<?php

namespace App\Http\Requests\API\Cart;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
use App\Models\ProductAccess;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
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
        $user_id  = Auth::guard('student')->id();
        $rules = [
            'product_id' => [
                'required',
                'exists:products,id',
                function($attribute, $value, $fail) use ($user_id){
                    if (ProductAccess::query()->where('product_id', $value)->where('user_id',$user_id)->exists()) {
                        $fail('این محصول قبلا خریداری شده است');
                    }
                },
            ],
        ];

        $product = Product::find($this->input('product_id'));

        if ($product && $product->product_type_id === ProductTypeEnum::CUSTOM_PACKAGE) {
            $rules['packages'] = ['required', 'array'];
            $rules['packages.*.product_id'] = [
                'required',
                'exists:products,id',
                function($attribute, $value, $fail) use ($user_id){
                    if (ProductAccess::query()->where('product_id', $value)->where('user_id',$user_id)->exists()) {
                        $fail('یکی از محصولات انتخابی در پکیج قبلا خریداری شده است.');
                    }
                },
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'product_id.required' => 'محصول الزامی است',
            'product_id.exists' => 'محصول انتخاب شده موجود نیست.',
            'packages.required' => 'انتخاب دوره در پکیج الزامی است',
            'packages.array' => 'The packages must be an array.',
            'packages.*.product_id.required' => 'هر پکیج باید شامل محصول باشد.',
            'packages.*.product_id.exists' => 'محصول انتخاب شده موجود نیست.',
        ];
    }
}
