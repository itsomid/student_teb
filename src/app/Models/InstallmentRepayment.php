<?php

namespace App\Models;

use App\Enums\InstallmentStatusEnum;
use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;

class InstallmentRepayment extends Model
{
    use Filterable;
    public $filterNameSpace = "App\Filters\InstallmentFilters";

    protected $fillable = [
        'amount', 'expired_at', 'user_id', 'order_item_id', 'status'
    ];

    protected function casts(): array
    {
        return [
            'status' => InstallmentStatusEnum::class
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order_item(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function status()
    {
        return \App\Enums\InstallmentStatusEnum::STATUS_LABEL[$this->status->value];
    }

    public function status_color()
    {
        return \App\Enums\InstallmentStatusEnum::STATUS_COLOR[$this->status->value];
    }

    public function expire_at()
    {
        return Jalalian::forge($this->expired_at)->toDayDateTimeString();
    }
    public function amount()
    {
        return number_format($this->amount);
    }
}
