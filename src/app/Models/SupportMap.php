<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SupportMap extends Model
{
    use HasFactory;

    protected $fillable= ['title', 'grades'];

    protected function casts(): array
    {
        return [
            'grades'    =>  Json::class,
        ];
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class);
    }
}
