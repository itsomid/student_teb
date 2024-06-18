<?php

namespace app\Http\Requests\Api\Auth;

use App\Rules\RequestValidRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
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
            'mobile' => 'required|digits:11',
            'token' => ['required', 'digits:5', 'bail', new RequestValidRule($this->get('mobile'))],
        ];
    }
}
