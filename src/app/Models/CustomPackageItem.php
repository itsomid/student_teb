<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomPackageItem extends Model
{
    protected $fillable = [
        'product_id'
    ];
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function customPackage(): BelongsTo
    {
        return $this->belongsTo(CustomPackage::class,'custom_package_id');
    }
}
