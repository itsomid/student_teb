<?php

namespace App\Http\Requests\ClassBlock;

use App\Functions\DateFormatter;
use App\Models\Classes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'product_id' => ['required', Rule::exists(Classes::class, 'product_id')],
            'description' => ['sometimes'],
            'users_list' => ['required'],
            'expired_at' => ['required', 'date']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'expired_at' => DateFormatter::format($this->expired_at),
        ]);
    }
}
