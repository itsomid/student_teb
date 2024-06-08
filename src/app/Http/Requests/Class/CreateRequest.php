<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        return [
            'name'                   => ['required', 'max:255'],
            'description'            => ['required', 'max:1000'],
            'holding_date'           => ['required'],
            'status'                 => ['required', 'in:upcoming,ongoing,postponed,ended'],
            'parent_id'              => ['nullable', 'numeric'],
            'studio_description'     => ['nullable'],
            'qa_is_active'           => ['nullable'],
            'homework_is_active'     => ['nullable'],
            'homework_is_mandatory'  => ['nullable'],
            'report_is_mandatory'    => ['nullable'],
            'is_free'                => ['nullable'],
            'offline_link_woza'      => ['required', 'url'],
            'offline_link_vod'       => ['required', 'url'],
            'emergency_link'         => ['nullable', 'url'],
            'attached_file_link'     => ['nullable', 'url'],
        ];
    }
}
