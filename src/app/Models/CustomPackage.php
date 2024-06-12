<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomPackage extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'courses',
        'product_id',
        'section_name',
    ];
    /**
     * @return HasMany
     */

    public function items(): HasMany
    {
        return $this->hasMany(CustomPackageItem::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function getCoursesJson($packages): array
    {
        $packages->load('product');

        $data = [];
        foreach($packages as $section) {
            $courseFetched = [];
            foreach($section->items as $item) {
                $courseFetched[] = [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'image_src' => $item->product->img_filename,
                ];
            }

            $data[] = [
                'courses' => $courseFetched,
                'id' => $section->id,
                'title' => $section->section_name
            ];

        }
        return $data;
    }
}
