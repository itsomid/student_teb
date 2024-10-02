<?php

namespace App\Models;

use App\Enums\CardTransactionStatusEnum;
use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

class CardTransaction extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'student_id', 'transaction_id', 'tracking_code', 'amount', 'status', 'paid_date', 'filename', 'description'
    ];

    public $filterNameSpace = 'App\Filters\CardTransactionFilters';


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

    /**
     * Get image filename with full url
     * @return string
     */
    public function getImageUrl(): string
    {
        return asset('/images/card-transactions/'.$this->filename);
    }

    /**
     * Convert to Jalali Date
     * @return string
     */
    public function paid_date(): string
    {
        return Jalalian::forge($this->paid_date)->format('%Y/%m/%d H:i:s');
    }

    /**
     * Can only see own cards
     * @param Builder $query
     * @param int $userId
     * @return mixed
     */
    public function scopeOwnCards(Builder $query, int $userId): Builder
    {
        return $query
            ->whereHas('student', fn ($query) => $query->where('sale_support_id', $userId))
            ->orWhere('student_id', $userId);
    }
}
