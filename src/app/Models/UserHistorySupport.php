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

    public $fillable = [
        'user_id',
        'user_support_id',
        'description',
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
