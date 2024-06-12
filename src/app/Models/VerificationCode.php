<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $fillable= ['receptor', 'code', 'expire_at'];

    public static function getPayload($userId)
    {
        return [
            'user_id'    => $userId,
            'expired_at' => now()->addMinutes(env('EXPIRATION_PER_MINUTES'))->getTimestamp(),
        ];
    }
}
