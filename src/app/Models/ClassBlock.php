<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'student_id', 'product_id', 'description'
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
}
