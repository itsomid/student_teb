<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'product_id',
        'cash_amount',
        'agent_commission_amount',
        'order_item_id',
    ];

    /**
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function order_item(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
}
