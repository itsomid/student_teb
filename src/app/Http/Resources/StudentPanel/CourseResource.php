<?php

namespace App\Http\Resources\StudentPanel;

use App\Enums\ProductCategoryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=>$this->id,
            'name' => $this->name,
            "description" => $this->description,
            "teacher_name" => optional($this->teacher)->fullname(),
            "original_price" => $this->getPrice(),
            "off_price" => $this->off_price,
            "sort_num" => $this->sort_num,
            "product_type_id" => $this->product_type_id,
            "img_filename" => $this->img_filename,
            "has_installment" => $this->has_installment,
            "is_purchasable" => (int)$this->is_purchasable,
            "show_in_list" => (int)$this->show_in_list,
            'holding_days' => $this->course->holding_days(),
            'start_time' => $this->course->start_time(),
            'finish_time' => $this->course->end_time(),
            'start_date' => $this->course->start_date,
            'course_id' => $this->course->id,
            "grades" => $this->categories->where('type', ProductCategoryType::GRADE)->pluck('id'),
            "lessons" => $this->categories->where('type', ProductCategoryType::LESSON)->pluck('id'),
            "courses" => $this->categories->where('type', ProductCategoryType::COURSE)->pluck('id'),

        ];
    }
}
