<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;

class TeacherCommissionChangeHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_percentage',
        'tax_block_percentage',
        'changed_by',
        'teacher_id',
        'product_id',
        'all_data'
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'all_data' => Json::class
        ];
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
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'teacher_id');
    }

    /**
     * @return BelongsTo
     */
    public function admin_changed_by(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'changed_by');
    }

    public function created_at(): string
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
}
