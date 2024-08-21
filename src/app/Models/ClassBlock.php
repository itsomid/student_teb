<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassBlock extends Model
{
    use HasFactory;

    /**
     * Check student block not expired
     * @param Builder $q
     * @return Builder
     */
    public function scopeValid(Builder $q): Builder
    {
        return $q->whereDate('expired_at', '<', now());
    }
}
