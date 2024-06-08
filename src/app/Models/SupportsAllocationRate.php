<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportsAllocationRate extends Model
{
    use HasFactory;

    protected $fillable=['sale_support_id', 'allocation_rate', 'is_active'];

    public function saleSupport(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'sale_support_id');
    }
}
