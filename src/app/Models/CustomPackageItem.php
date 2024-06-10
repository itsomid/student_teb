<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPackageItem extends Model
{
    protected $fillable = [
        'product_id'
    ];
    use HasFactory;
}
