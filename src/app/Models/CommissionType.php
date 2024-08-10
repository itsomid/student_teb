<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommissionType extends Model
{
    use SoftDeletes;

    protected $fillable=['title', 'percentage'];

    public function commissions() : HasMany
    {
        return $this->hasMany(Commission::class, 'type_id');
    }

    public static function setLogForCommissionsOnUpdate($type, $percentage) : void
    {
        $commissions= Commission::query()->where('type_id', $type->id)->withTrashed()->get();
        foreach ($commissions as $commission)
            $commission->histories()->create([
                'changed_by'  => auth()->id(),
                'type_id'     => $type->id,
                'percentage'  => $percentage,
                'description' => Commission::ACTIONS['PERCENTAGE_CHANGED']['description'],
                'theme'       => Commission::ACTIONS['PERCENTAGE_CHANGED']['theme'],
            ]);
    }
}
