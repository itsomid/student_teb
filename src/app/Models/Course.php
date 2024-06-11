<?php

namespace App\Models;

use \App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Morilog\Jalali\Jalalian;

class Course extends Model
{
    use HasFactory, Filterable;

    protected $table = 'courses';
    public $fillable = [
        'product_id',
        'holding_days',
        'holding_hours',
        'start_date',
        'about_course',
        'qa_status'
    ];

    public $filterNameSpace = 'App\Filters\CourseFilters';

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }

    public function scopeSort($q)
    {
        return $q->orderBy('sort_num');
    }

    public function scopeSearch($q, $keyword)
    {
        return $q->where('id', $keyword)
            ->orWhereHas('product', fn($query) => $query->where('name', 'LIKE', "%{$keyword}%"));
    }

    public function scopeTeacherAssistance($q, $userId)
    {
        $user = Staff::findOrFail($userId);
        if (isset($user->options) && array_key_exists('teacher_id', $user->options)) {
            return $q->OrwhereHas('product', fn($q2) => $q2->where('user_id', $user->options['teacher_id']));
        }
    }

    public function scopeCheckPermissionToGetList($query, $userId)
    {
        return $query->whereHas('product', fn ($query2) => $query2->where('user_id', $userId));
    }

    public function image(): string
    {
        return asset('images/Courses').'/'.$this->product->img_filename;
    }

    public function subscription_start_at(): string
    {
        return Jalalian::forge($this->product->subscription_start_at)->format('%Y/%m/%d H:i:s');
    }
    public function final_installment_date(): string
    {
        return Jalalian::forge($this->product->final_installment_date)->format('%Y/%m/%d H:i:s');
    }

    public function holding_days(): ?array
    {
        $days= [
            0 => '',
            1 => 'شنبه',
            2 => 'یکشنبه',
            3 => 'دوشنبه',
            4 => 'سشنبه',
            5 => 'چهارشنبه',
            6 => 'پنجشنبه',
            7 => 'جمعه',
        ];
        if (!is_null($this?->product?->options)){
            return [
                $days[intval($this?->product?->options['holding_days1'])],
                $days[intval($this?->product?->options['holding_days2'])],
                $days[intval($this?->product?->options['holding_days3'])],
            ];
        }
        return [];
    }
    public function holding_time(): array
    {
        return [
            $this?->product?->options['holding_hours1'][0] ?? '',
            isset($this?->product?->options['holding_hours2'][0]) ?  ' - ' : null,
            $this?->product?->options['holding_hours2'][0] ?? null,
            isset($this?->product?->options['holding_hours3'][0]) ?  ' - ' : null,
            $this?->product?->options['holding_hours3'][0] ?? null,
        ];
    }
}
