<?php

namespace App\Services;

use App\DTO\StudentCourse\CoursePurchasedResponseDTO;
use App\Models\Course;

class StudentCourseService
{

    /**
     * @param StudentAccountService $studentAccountService
     */
    public function __construct(private readonly StudentAccountService $studentAccountService)
    {
    }

    public function getPurchasedCourses(int $userId): array
    {
        $purchasedProduct = $this->studentAccountService->getPurchasedProductIds($userId);

        $courses = Course::query()
            ->with('product')
            ->whereIn('product_id', $purchasedProduct)
            ->get();

        return $courses->map(fn(Course $course) =>
            resolve(CoursePurchasedResponseDTO::class)
            ->setCourseId($course->id)
            ->setProductId($course->product_id)
            ->setName($course->product->name)
            ->setImage($course->product->getImageUrl())
            ->setHoldingDays1($course->product->options['holding_days1'])
            ->setHoldingDays2($course->product->options['holding_days2'])
            ->setHoldingDays3($course->product->options['holding_days3'])
            ->setHoldingHours1($course->product->options['holding_hours1'])
            ->setHoldingHours2($course->product->options['holding_hours2'])
            ->setHoldingHours3($course->product->options['holding_hours3'])
        )->toArray();
    }
}
