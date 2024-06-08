<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function search()
    {
        $courses= Course::search(['key' => request()->input('key')])->map(function ($course){
            return [
                'id'          => $course->id,
                'title'       => $course->product->name
            ];
        });


        return response()->json($courses);
    }
}
