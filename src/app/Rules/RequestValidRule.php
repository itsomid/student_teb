<?php

namespace App\Rules;

use App\Models\VerificationCode;
use App\Models\VerifyUser;
use Illuminate\Contracts\Validation\Rule;

class RequestValidRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private $mobile)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return VerifyUser::query()
            ->where('mobile', $this->mobile)
            ->where('token', $value)
            ->where('ip', request()->getClientIp())
            ->where('created_at', '>', now()->subMinutes(10))
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your request is invalid.';
    }
}
