<?php

namespace App\Http\Resources\StudentPanel;

use App\Enums\ProductCategoryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map( fn ($item) => [
            'id'                =>$item->id,
            "name"              => $item->name,
            "teacher_name"      => optional($item->teacher)->fullname(),
            "original_price"    => $item->getPrice(),
            "off_price"         => $item->off_price,
            "sort_num"          => $item->sort_num,
            "product_type_id"   => $item->product_type_id,
            "img_filename"      => $item->img_filename,
            "is_purchasable"    => (int)$item->is_purchasable,
            "show_in_list"      => (int)$item->show_in_list,
            "grades"            => $item->categories->where('type', ProductCategoryType::GRADE)->pluck('id'),
            "lessons"           => $item->categories->where('type', ProductCategoryType::LESSON)->pluck('id'),
            "courses"           => $item->categories->where('type', ProductCategoryType::COURSE)->pluck('id'),
        ])->toArray();

    }
}
