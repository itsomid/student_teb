<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductCategoryType;
use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentPanel\CourseResource;
use App\Http\Resources\StudentPanel\CustomPackageResource;
use App\Http\Resources\StudentPanel\StoreCollection;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StoreController extends Controller
{
    public function store()
    {

        $products = Product::activeCourses()->with([
            'categories' => function ($query) {
                $query->select('id', 'type', 'name');
            }, 'teacher' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])->orderByRaw('sort_num IS NULL ASC, sort_num ASC')->get();

        return response()->json([
            'data' => new StoreCollection($products)
        ]);
    }

    public function storeItemDetails($product)
    {
        try {
            $product = Product::findOrFail($product);

            if ($product->product_type_id === ProductTypeEnum::COURSE) {

                return response()->json([
                    'data' => new CourseResource($product)
                ]);
            }


            if ($product->product_type_id === ProductTypeEnum::CUSTOM_PACKAGE) {
                return response()->json([
                    'data' => new CustomPackageResource($product)
                ]);
            }

            return response()->json(['message' => 'نوع محصول اشتباه است'], 400);

        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'محصول موجود نیست.'], 404);
        }

    }

    public function packageShow(Product $product)
    {
        return response()->json([
            'data' => new CustomPackageResource($product)
        ]);
    }


}
