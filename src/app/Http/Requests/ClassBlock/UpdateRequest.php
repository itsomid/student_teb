<?php

namespace App\Http\Requests\ClassBlock;

use App\Functions\DateFormatter;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        return [
            'product_id' => ['required', Rule::exists(Classes::class, 'product_id')],
            'description' => ['sometimes'],
            'user_id' => ['required', Rule::exists(User::class, 'id')],
            'expired_at' => ['required', 'date', 'after_or_equal:today']
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'expired_at' => DateFormatter::format($this->expired_at),
        ]);
    }
}
