<?php

namespace App\Models;

use App\Enums\ProductCategoryType;
use App\Helpers\Filterable\Filterable;
use App\Helpers\Filterable\FilterEqual;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Util\Filter;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'type',
        'archived'
    ];

    protected $casts = [
        'type' => ProductCategoryType::class
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('archived', 0);
    }
}
