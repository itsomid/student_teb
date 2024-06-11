<?php

namespace App\Http\Requests\Auth;

use App\Rules\RequestValidRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mobile'            =>  'required|regex:/^09[0-9]{9}$/|exists:users,mobile',
            'name'              =>  'required|string|max:255',
            'reagent_code'      =>  'nullable|string|max:255',
            'grade'             =>  'required|in:12,11,10,9,8,7,6,5,4,3,2,1,ghadim',
            'field_of_study'    =>  'required|in:4,3,2,1,0',
            'sms_token'         =>  ['required','digits:5', 'bail',new RequestValidRule($this->get('mobile'))],
        ];
    }
}
