<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Morilog\Jalali\Jalalian;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'transaction_type', 'user_description', 'system_description'
    ];

    protected function casts(): array
    {
        return [
            'transaction_type' => TransactionTypeEnum::class
        ];
    }

    /**
     * @return BelongsTo
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function deposit(): HasOne
    {
        return $this->hasOne(Deposit::class);
    }

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->toDayDateTimeString();
    }

    public function amount(): string
    {
        return number_format($this->amount);
    }
}
