<?php

namespace app\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PasswordLoginRequest extends FormRequest
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

    public function rules()
    {
        $rules = [
            'mobile'   => 'required',
            'password' => 'required|max:64',
        ];

        if (cache()->has(request()->ip()) and cache()->get(request()->ip()) >= 3)
        {
           $rules['captcha'] ='required|captcha_api:'.request('key').',flat';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'mobile.required'        => 'شماره تلفن الزامی است.',
            'password.required'      => 'کلمه ی عبور الزامی است.',
            'password.max'           => 'طول کلمه ی عبور وارد شده بیش از حد مجاز است.',
            'captcha.required'       => 'عبارت امنیتی الزامی است.',
            'captcha.captcha_api'    => 'عبارت امنیتی صحیح نمی باشد.'
        ];
    }
}
