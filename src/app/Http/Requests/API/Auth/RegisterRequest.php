<?php

namespace App\Http\Requests\API\Auth;

use App\Models\VerificationCode;
use App\Rules\RequestValidRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'referral_id'      =>  'nullable|string|max:255',
            'grade'             =>  'required|in:13,12,11,10,9,8,7,6,5,4,3,2,1',
            'field_of_study'    =>  'required|in:4,3,2,1,0',
            'sms_token'         =>  'required|digits:5|bail'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'وارد کردن نام الزامی می باشد.',
            'name.max' => 'طول نام وارد شده بیش از حد مجاز است.',
            'grade.required' => 'لطفا پایه ی تحصیلی خود را وارد کنید',
            'grade.in' => 'پایه ی تحصیلی انتخاب شده صحیح نمی باشد.',
            'field_of_study.required' => 'لطفا رشته ی تحصیلی خود را وارد کنید.',
            'field_of_study.in' => 'رشته ی تحصیلی وارد شده صحیح نمی باشد.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $mobile = $this->input('mobile');
            $smsToken = $this->input('sms_token');

            if (!VerificationCode::query()
                ->where('receptor', $mobile)
                ->where('code', $smsToken)
                ->where('created_at', '>', now()->subMinutes(10))
                ->exists()) {
                $validator->errors()->add('sms_token', 'کد وارد شده منقضی شده یا موجود نیست.');
            }
        });
    }
}
