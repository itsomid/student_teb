<?php

namespace App\Http\Requests\Api\Cart;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
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
        $rules = [
            'product_id' => ['required', 'exists:products,id'],
        ];
        //TODO: give product type id from front (in request)

        $product = Product::find($this->input('product_id'));

        if ($product && $product->product_type_id === ProductTypeEnum::CUSTOM_PACKAGE) {
            $rules['packages'] = ['required', 'array'];
            $rules['packages.*.product_id'] = ['required', 'exists:products,id'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'product_id.required' => 'product_id الزامی است',
            'product_id.exists' => 'محصول انتخاب شده موجود نیست.',
            'packages.required' => 'انتخاب دوره در پکیج الزامی است',
            'packages.array' => 'The packages must be an array.',
            'packages.*.product_id.required' => 'هر پکیج باید شامل محصول باشد.',
            'packages.*.product_id.exists' => 'محصول انتخاب شده موجود نیست.',
        ];
    }
}
