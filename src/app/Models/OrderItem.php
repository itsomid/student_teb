<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'final_price', 'product_price', 'discount_price', 'user_gift_amount'];
    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasMany
     */
    public function installment_repayment(): HasMany
    {
        return $this->hasMany(InstallmentRepayment::class);
    }

    /**
     * @return HasMany
     */
    public function product_access(): HasMany //Maybe HasOne
    {
        return $this->hasMany(ProductAccess::class, 'order_item_id');
    }

    /**
     * this relation for get cash amount and agent commission for every order items
     * @return HasOne
     */
    public function cash_amount(): HasOne
    {
        return $this->hasOne(CashAmount::class);
    }
}
