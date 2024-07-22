<?php

namespace App\Http\Resources\StudentPanel;

use App\DTO\StudentCourse\CourseClassesPurchasedResponseDTO;
use App\DTO\StudentCourse\CoursePurchasedResponseDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseClassesCollection extends ResourceCollection
{
    public function __construct($resource, private CoursePurchasedResponseDTO $courseDTO)
    {
        parent::__construct($resource);

    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->courseDTO->getProductId(),
            'course_id' => $this->courseDTO->getCourseId(),
            'name' => $this->courseDTO->getName(),
            'teacher_name' => $this->courseDTO->getTeacherName(),
            'product_type_id' => $this->courseDTO->getProductTypeId(),
            'image_src' => $this->courseDTO->getImage(),
            'holding_days1' => $this->courseDTO->getHoldingDays1(),
            'holding_days2' => $this->courseDTO->getHoldingDays2(),
            'holding_days3' => $this->courseDTO->getHoldingDays3(),
            'holding_hours1' => $this->courseDTO->getHoldingHours1(),
            'holding_hours2' => $this->courseDTO->getHoldingHours2(),
            'holding_hours3' => $this->courseDTO->getHoldingHours3(),

            'classes' => $this->collection->map(fn(CourseClassesPurchasedResponseDTO $DTO) => [
            'id' => $DTO->getClassId(),
            'name' => $DTO->getName(),
            'status' => $DTO->getStatus(),
            'is_free' => $DTO->getIsFree(),
            'holding_date' => $DTO->getHoldingDate(),
        ])->toArray()
        ];
    }
}
