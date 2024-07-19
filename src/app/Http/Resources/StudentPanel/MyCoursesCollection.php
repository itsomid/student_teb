<?php

namespace App\Http\Resources\StudentPanel;

use App\DTO\StudentCourse\CoursePurchasedResponseDTO;
use App\Enums\ProductCategoryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MyCoursesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(fn(CoursePurchasedResponseDTO $DTO) => [
            'product_id' => $DTO->getProductId(),
            'course_id' => $DTO->getCourseId(),
            'name' => $DTO->getName(),
            'teacher_name' => $DTO->getTeacherName(),
            'product_type_id' => $DTO->getProductTypeId(),
            'image_src' => $DTO->getImage(),
            'holding_days1' => $DTO->getHoldingDays1(),
            'holding_days2' => $DTO->getHoldingDays2(),
            'holding_days3' => $DTO->getHoldingDays3(),
            'holding_hours1' => $DTO->getHoldingHours1(),
            'holding_hours2' => $DTO->getHoldingHours2(),
            'holding_hours3' => $DTO->getHoldingHours3(),
            "courses" => $DTO->getCoursesCategory(),

        ])->toArray();
    }
}
