<?php

namespace App\Models;

use App\Enums\ProductAccessType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id', 'product_id', 'user_id', 'effective_from_datetime', 'effective_to_datetime', 'access_reason_type'
    ];

    protected function casts(): array
    {
        return [
            'access_reason_type' => ProductAccessType::class
        ];
    }
}
