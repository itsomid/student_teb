<?php

namespace App\Http\Requests\StudentAccount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChargeAccountRequest extends FormRequest
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
            'amount' =>  str_replace(',', '', $this->amount)
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
            'amount' => ['required', 'integer', 'min:1000'],
            'user_id' => ['required', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'user_description' => ['nullable'],
            'gift_credit' => ['sometimes'],
        ];
    }
}
