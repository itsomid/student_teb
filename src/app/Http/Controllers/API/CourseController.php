<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function search()
    {
        $courses = Product::query()
            ->where('product_type_id', ProductTypeEnum::COURSE)
            ->select('id', 'name', 'img_filename')
            ->get();

        return response()->json($courses->map(fn($course) => [
            'id'          => $course->id,
            'title'       => $course->name,
            'image'       => $course->getImageSrc()
        ]));
    }
}
