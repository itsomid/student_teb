<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserHistorySupport extends Model
{
    use HasFactory, Filterable;
    public $filterNameSpace = 'App\Filters\UserHistorySupportFilters';

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'expired_at' => 'datetime'
        ];
    }

    public $fillable = [
        'user_id',
        'user_support_id',
        'support_role',
        'description',
        'start_time',
        'end_time',
        'expired_at',
        'created_at'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supporter(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'user_support_id');
    }
}
