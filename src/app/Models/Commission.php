<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use SoftDeletes;
    protected $fillable=['support_id', 'type_id'];

    const ACTIONS= [
        'COLLABORATION_STARTED' => ['description' => 'آغاز همکاری',        'theme' => 'success'],
        'TYPE_CHANGED'          => ['description' => 'تغییر نوع همکاری',    'theme' => 'warning'],
        'PERCENTAGE_CHANGED'    => ['description' => 'تغییر درصد همکاری',   'theme' => 'danger'],
        'DELETED'               => ['description' => 'حذف شد',          'theme' => 'primary'],
        'RESTORED'              => ['description' => 'بازیابی شد',         'theme' => 'primary'],
    ];

    public function support():BelongsTo
    {
        return $this->belongsTo(Admin::class, 'support_id');
    }

    public function type():BelongsTo
    {
        return $this->belongsTo(CommissionType::class, 'type_id')->withTrashed();
    }

    public function histories():HasMany
    {
        return $this->hasMany(CommissionHistory::class, 'commission_id');
    }
}
