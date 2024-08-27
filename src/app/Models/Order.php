<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'vat_tax',
        'final_price',
        'total_payable_price',
        'total_discount',
        'repayment_count',
        'status',
        'user_id'
    ];

    /**
     * Casts attribute
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatusEnum::class
        ];
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
