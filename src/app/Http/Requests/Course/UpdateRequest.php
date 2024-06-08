<?php

namespace App\Http\Requests\Course;

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
        return [
            'product_type_id'           => ['required'],
            'user_id'                   => ['required'],
            'name'                      => ['required'],
            'description'               => ['required'],
            'original_price'            => ['nullable', 'numeric'],
            'off_price'                 => ['nullable', 'numeric'],
            'options'                   => ['nullable'],
            'sort_num'                  => ['nullable', 'numeric'],
            'img_filename'              => ['nullable'],
            'subscription_start_at'     => ['nullable'],
            'installment_count'         => ['required_if:has_installment,1', 'nullable', 'numeric'],
            'first_installment_ratio'   => ['required_if:has_installment,1'],
            'final_installment_date'    => ['required_if:has_installment,1'],
            'expiration_duration'       => ['nullable'],
            'start_date'                => ['required'],
            'about_course'              => ['required'],
            'is_purchasable'            => ['nullable', 'boolean'],
            'has_installment'           => ['nullable', 'boolean'],
            'show_in_list'              => ['nullable', 'boolean'],
            'qa_status'                 => ['nullable', 'boolean'],
            'categories'                => ['array'],
        ];
    }
}
