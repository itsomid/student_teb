<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'courses',
        'product_id',
        'section_name',
        'holding_date'
    ];
    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(CustomPackageItem::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
