<?php

namespace App\Models;

use App\Enums\InstallmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentRepayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'expired_at', 'user_id', 'order_item_id', 'status'
    ];

    protected function casts(): array
    {
        return [
            'status' => InstallmentStatusEnum::class
        ];
    }
}
