<?php

namespace App\Http\Resources\StudentPanel;

use App\DTO\StudentCourse\ClassDetailDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassDetailResource extends JsonResource
{
    public function __construct(ClassDetailDTO $resource)
    {
        $this->resource = $resource;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->getName(),
            'class_id' => $this->resource->getClassId(),
            'product_id' => $this->resource->getProductId(),
            'description' => $this->resource->getDescription(),
            'class_status' => $this->resource->getClassStatus(),
            'holding_date' => $this->resource->getHoldingDate(),
            'homework_is_active' => $this->resource->getIsActiveHomework(),
            'homework_is_force' => $this->resource->getIsForceHomework(),
            'report_is_force' => $this->resource->getIsForeReport(),
            'teacher_id' => $this->resource->getTeacherId(),
            'teacher_image' => $this->resource->getTeacherImage(),
            'course_name' => $this->resource->getCourseName(),
            'is_student_block' => $this->resource->getIsStudentBlock(),
            'student_block_description' => $this->when($this->resource->getIsStudentBlock(), $this->resource->getStudentBlockDescription()),
        ];
    }
}
