<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentPanel\MyCoursesCollection;
use App\Services\StudentCourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function __construct(private readonly StudentCourseService $courseService)
    {
    }

    public function myCourses(): MyCoursesCollection
    {
        $userId = Auth::guard('student')->id();

        $studentCourses = $this->courseService->getPurchasedCourses($userId);

        return new MyCoursesCollection($studentCourses);
    }
}
