<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeacherProductCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'teacher_id', 'product_percentage', 'tax_block_percentage'
    ];

    /**
     * @return BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'teacher_id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Teacher Paid Lists
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(TeacherPayments::class, 'product_id', 'product_id');
    }
}
