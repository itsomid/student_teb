<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherPayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'teacher_id', 'product_id', 'description', 'receipt_image', 'transaction_time'
    ];

    protected function casts(): array
    {
        return [
            'transaction_time' => 'datetime'
        ];
    }

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
}
