<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    const REF_DEFAULT_HEADER= ['Accept' => 'application/json'];

    protected $fillable=['key', 'value'];

    public static function REFAddress()
    {
        return cache()->has('setting.refAddress')
            ? cache()->get('setting.refAddress')
            : static::query()->where('key', 'ref_base_address')->first()->value;
    }

    public static function Kavenegar_key()
    {
        return cache()->has('setting.kavenegarKey')
            ? cache()->get('setting.kavenegarKey')
            : static::query()->where('key', 'kavenegar_key')->first()->value;
    }
}

