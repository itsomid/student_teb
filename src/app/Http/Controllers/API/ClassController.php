<?php

namespace App\Http\Controllers\API;

use App\DTO\StudentCourse\ClassDetailDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentPanel\ClassDetailResource;
use App\Services\StudentAccountService;
use App\Services\StudentCourseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{

    public function __construct(private readonly studentAccountService $studentAccountService, private readonly  StudentCourseService $courseService)
    {
    }


    public function show(int $productId): ClassDetailResource|Response
    {
        $userId = Auth::guard('student')->id();
        if (! $this->studentAccountService->hasAccessToProduct($userId, $productId)) {
            return response([
                'message' => 'شما دسترسی به این دوره ندارید.'
            ], Response::HTTP_FORBIDDEN);
        }

        return new ClassDetailResource(
            $this->courseService->getSingleClass($userId, $productId)
        );
    }
}
