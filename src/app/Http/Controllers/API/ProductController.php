<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Course;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search()
    {
        $courses= Course::search(['q' => request()->input('key')])->map(function ($course){
            return [
                'id'          => $course->product_id,
                'title'       => $course->name
            ];
        });


        return response()->json($courses);
    }
}
