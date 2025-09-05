<?php

namespace App\Models;

use App\Enums\ClassStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Classes extends Model
{
    use HasFactory;

    const statuses=[
        'upcoming'  => 'برگزار نشده است',
        'ongoing'   => 'در حال برگزاری',
        'postponed' => 'به تعویق افتاده',
        'ended'     => 'پایان یافته',
    ];

    protected $fillable=[
        'product_id',
        'course_id',
        'parent_id',
        'holding_date',
        'status',
        'is_free',
        'sort_num',
        'offline_link_woza',
        'offline_link_vod',
        'emergency_link',
        'attached_file_link',
        'studio_description',
        'qa_is_active',
        'homework_is_active',
        'homework_is_mandatory',
        'report_is_mandatory',
    ];

    protected function casts(): array
    {
        return [
            'holding_date' => 'datetime',
            'status' => ClassStatusEnum::class
        ];
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function parent_classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class,'parent_id');
    }

    public function sub_classes(): HasMany
    {
        return $this->hasMany(Classes::class,'parent_id');
    }

    public function status()
    {
        if ($this->status == 'upcoming')
            return 'برگزار نشده';

        if ($this->status == 'ongoing')
            return 'در حال برگزاری';

        if ($this->status == 'postponed')
            return 'به تعویق افتاده';

        if ($this->status == 'ended')
            return 'پایان یافته';
    }


}
