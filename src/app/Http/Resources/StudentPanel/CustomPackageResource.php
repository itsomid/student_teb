<?php

namespace App\Http\Resources\StudentPanel;

use App\Enums\ProductCategoryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        foreach ($this->packages as $section) {
            $courses = [];
            // Loop through each item in the section
            foreach ($section->items as $item) {
                // Loop through each product in the item
                $courses[] = [
                    'id'=>$item->product->id,
                    'name' => $item->product->name,
                    'image' => $item->product->img_filename,
                    'start_date' => $item->product->course->start_date,
                    'holding_days' => $item->product->course->holding_days(),
                    'start_time' => $item->product->course->start_time(),
                    'finish_time' => $item->product->course->end_time(),
                ];
            }

            $sections[] = [
                'id' => $section->id,
                'name' => (string)$section->section_name,
                'courses' => $courses,
            ];
        }

        return [
            'id'=>$this->id,
            'name' => $this->name,
            'description' => $this->description,
            'teacher_name' => optional($this->teacher)->fullname(),
            'original_price' => $this->getPrice(),
            'off_price' => $this->off_price,
            'sort_num' => $this->sort_num,
            'product_type_id' => $this->product_type_id,
            'img_filename' => $this->img_filename,
            'has_installment' => $this->has_installment,
            'installment_count' => $this->installment_count,
            'package' => CustomPackageSectionResource::collection($this->packages),
            'is_purchasable' => (int)$this->is_purchasable,
            'show_in_list' => (int)$this->show_in_list,
            'grades' => $this->categories->where('type', ProductCategoryType::GRADE)->pluck('id'),
            'lessons' => $this->categories->where('type', ProductCategoryType::LESSON)->pluck('id'),
            'courses' => $this->categories->where('type', ProductCategoryType::COURSE)->pluck('id'),

        ];
    }
}
