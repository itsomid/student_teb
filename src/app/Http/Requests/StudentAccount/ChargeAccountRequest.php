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
            'amount' => str_replace(',', '', $this->amount),
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
            'amount' => ['required', 'integer', 'min:10000'],
            'user_id' => ['required', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'user_description' => ['nullable'],
            'gift_credit' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'انتخاب کاربر الزامی است.',
            'user_id.exists' => 'کاربر وجود ندارد.',
            'amount.required' => 'مبلغ اعتبار الزامی است.',
            'amount.min' => 'مبلغ باید حداقل ۱۰۰۰۰ ریال باشد.',
        ];
    }
}
