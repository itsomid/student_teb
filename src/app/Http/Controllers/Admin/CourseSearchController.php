<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CourseSearchCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseSearchController extends Controller
{
    public function __invoke($name): Response
    {
        $products = Product::query()
            ->with('children')
            ->where('name', 'LIKE', "%$name%")
            ->where('product_type_id', ProductTypeEnum::COURSE)
            ->get();

        return response(
          new CourseSearchCollection($products)
        );
    }
}
