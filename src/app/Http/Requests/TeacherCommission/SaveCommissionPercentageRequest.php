<?php

namespace App\Http\Requests\TeacherCommission;

use App\Rules\ProductKeyIsExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveCommissionPercentageRequest extends FormRequest
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
            'product_checkbox_all' => ['required', 'array', new ProductKeyIsExistsRule()],
            'product_percentage' => ['required', 'array', new ProductKeyIsExistsRule()],
            'product_percentage.*' => ['integer'],
            'tax_percentage' => ['required', 'array', new ProductKeyIsExistsRule()],
            'tax_percentage.*' => ['integer'],
            'product_checked' => ['required', 'array', new ProductKeyIsExistsRule()],
            'product_checked.*' => ['integer']
        ];
    }
}
