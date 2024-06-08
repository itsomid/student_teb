<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralCode extends Model
{
    use SoftDeletes, HasFactory, Filterable;

    public $filterNameSpace = 'App\Filters\ReferralCodeFilters';

    public $fillable = [
        'code',
        'gift_credit',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function registered_users(): HasMany
    {
        return $this->hasMany(User::class,'referral_id');
    }

    public function canDoAction($user_id)
    {
        return $this->user_id === $user_id;
    }

}
