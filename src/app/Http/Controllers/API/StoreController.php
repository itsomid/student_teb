<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductCategoryType;
use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentPanel\CourseResource;
use App\Http\Resources\StudentPanel\CustomPackageResource;
use App\Http\Resources\StudentPanel\StoreCollection;
use App\Models\Product;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Exceptions\ItemDoesNotExistsInShoppingCart;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function store()
    {

        $products = Product::activeCourses()->with([
            'categories' => function ($query) {
                $query->select('id', 'type');
            }, 'teacher' => function ($query) {
                $query->select('id', 'first_name', 'last_name');
            }])->orderBy('sort_num')->get();

        return response()->json([
            'data' => new StoreCollection($products)
        ]);
    }

    public function storeItemDetails(Product $product)
    {

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
    }

    public function packageShow(Product $product)
    {
        return response()->json([
            'data' => new CustomPackageResource($product)
        ]);
    }


}
