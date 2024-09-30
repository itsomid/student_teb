<?php

namespace App\Models;

use App\Enums\CardTransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id', 'tracking_code', 'amount', 'status', 'paid_date', 'filename', 'description'
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'status' => CardTransactionStatusEnum::class,
            'paid_date' => 'datetime'
        ];
    }

    /**
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
