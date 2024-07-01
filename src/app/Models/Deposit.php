<?php

namespace App\Models;

use App\Enums\DepositTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_type', 'user_id', 'admin_id'
    ];

    protected function casts(): array
    {
        return [
            'deposit_type' => DepositTypeEnum::class
        ];
    }
}
