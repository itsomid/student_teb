<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductCategoryType;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\StoreCollection;
use App\Models\Product;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

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

    public function storeItem(Product $product)
    {

        if (!$product) {
            return response()->json(Response::HTTP_NOT_FOUND);
        }
        if ($product->product_type_id === ProductCategoryType::COURSE){

        }
        return $product;
    }
}
