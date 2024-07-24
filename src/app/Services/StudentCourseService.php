<?php

namespace App\Services;

use App\DTO\StudentCourse\ClassDetailDTO;
use App\DTO\StudentCourse\CourseClassesPurchasedResponseDTO;
use App\DTO\StudentCourse\CoursePurchasedResponseDTO;
use App\Exceptions\ClassNotFoundException;
use App\Models\Classes;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * @param int $productId
     * @return CoursePurchasedResponseDTO
     */
    public function getCourse(int $productId): CoursePurchasedResponseDTO
    {
        $course = Course::query()->where('product_id', $productId)->first();
        return resolve(CoursePurchasedResponseDTO::class)
            ->setCourseId($course->id)
            ->setProductTypeId($course->product->product_type_id)
            ->setProductId($course->product_id)
            ->setTeacherName($course->product->teacher->fullname())
            ->setName($course->product->name)
            ->setImage($course->product->getImageUrl())
            ->setHoldingDays1($course->product->options['holding_days1'])
            ->setHoldingDays2($course->product->options['holding_days2'])
            ->setHoldingDays3($course->product->options['holding_days3'])
            ->setHoldingHours1($course->product->options['holding_hours1'])
            ->setHoldingHours2($course->product->options['holding_hours2'])
            ->setHoldingHours3($course->product->options['holding_hours3']);
    }

    /**
     * Returns Classes of a course
     * @param int $userId
     * @param int $productId
     * @return array
     */
    public function getPurchasedCourseClasses(int $userId, int $productId): array
    {
        $purchasedProductLeaves = $this->studentAccountService->getProductChildrenIdsAccess($userId);

        $classes = Classes::query()
            ->select('id', 'status', 'is_free', 'product_id')
            ->with('product')
            ->whereHas('product')
            ->whereHas('course', fn(Builder $q) => $q->where('product_id', $productId))
            ->whereIn('product_id', $purchasedProductLeaves)
            ->get();

        return $classes->map(function (Classes $class) {
            return resolve(CourseClassesPurchasedResponseDTO::class)
                ->setClassId($class->id)
                ->setName($class->product->name)
                ->setStatus($class->status)
                ->setIsFree($class->is_free);
                }
        )->toArray();
    }

    public function getSingleClass(int $productId): ClassDetailDTO
    {
        $class = Classes::query()->with('product', 'course')->where('product_id', $productId)->first();

        if (empty($class)) {
            throw new ClassNotFoundException();
        }

        return resolve(ClassDetailDTO::class)
                ->setName($class->product->name)
                ->setClassId($class->id)
                ->setProductId($class->product_id)
                ->setTeacherId($class->product->user_id)
                ->setIsActiveHomework($class->homework_is_active)
                ->setIsForceHomework($class->homework_is_mandatory)
                ->setHoldingDate($class->holding_date)
                ->setClassStatus($class->status)
                ->setIsForeReport($class->report_is_mandatory)
                ->setDescription($class->product->description)
                ->setQaStatus($class->qa_is_active)
                ->setTeacherImage($class->product->teacher->avatar())
                ->setCourseName($class->course->product->name);
    }
}
