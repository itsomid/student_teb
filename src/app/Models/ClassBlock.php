<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;

class ClassBlock extends Model
{

    use HasFactory, Filterable;

    /**
     * Check student block not expired
     * @param Builder $q
     * @return Builder
     */
    public function scopeValid(Builder $q): Builder
    {
        return $q->whereDate('expired_at', '<', now());
    }
    protected $fillable = [
        'student_id', 'product_id', 'description', 'expired_at'
    ];
    public $filterNameSpace = 'App\Filters\ClassBlockFilters';

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function expired_at(): string
    {
        return Jalalian::forge($this->expired_at)->format('%Y/%m/%d H:i:s');
    }
}
