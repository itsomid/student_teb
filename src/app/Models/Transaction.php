<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * @return HasOne
     */
    public function deposit(): HasOne
    {
        return $this->hasOne(Deposit::class);
    }
}
