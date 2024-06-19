<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'user_id', 'transaction_type'
    ];

    protected function casts(): array
    {
        return [
            'transaction_type' => TransactionTypeEnum::class
        ];
    }
}
