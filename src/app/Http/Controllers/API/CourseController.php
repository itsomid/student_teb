<?php

namespace App\Http\Controllers\API;

use App\DTO\StudentCourse\CourseClassesPurchasedResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentPanel\CourseClassesCollection;
use App\Http\Resources\StudentPanel\MyCoursesCollection;
use App\Services\StudentAccountService;
use App\Services\StudentCourseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct(private readonly StudentCourseService $courseService, private readonly StudentAccountService $studentAccountService)
    {
    }

    public function myCourses(): MyCoursesCollection
    {
        return new MyCoursesCollection(
            $this->courseService->getPurchasedCourses(Auth::guard('student')->id())
        );
    }

    public function classes(int $productId): CourseClassesCollection|Response
    {
        $userId = Auth::guard('student')->id();
        if (! $this->studentAccountService->hasAccessToProduct($userId, $productId)) {
            return response([
                'message' => 'شما دسترسی به این دوره ندارید.'
            ], Response::HTTP_FORBIDDEN);
        }

        return response(new CourseClassesCollection(
                $this->courseService->getPurchasedCourseClasses($userId, $productId),
                $this->courseService->getCourse($productId)
            ));
    }
}
