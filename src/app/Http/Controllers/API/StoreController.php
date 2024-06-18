<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductCategoryType;
use App\Http\Controllers\Controller;
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

        $products_array = [];

        foreach ($products as $product) {
            $products_array[] = [
                "name"              => $product->name,
                "teacher_name"      => optional($product->teacher)->fullname(),
                "original_price"    => $product->getPrice(),
                "off_price"         => $product->off_price,
                "sort_num"          => $product->sort_num,
                "product_type_id"   => $product->product_type_id,
                "img_filename"      => $product->img_filename,
                "is_purchasable"    => (int)$product->is_purchasable,
                "show_in_list"      => (int)$product->show_in_list,
                "grades"            => $product->categories->where('type', ProductCategoryType::GRADE)->pluck('id'),
                "lessons"           => $product->categories->where('type', ProductCategoryType::LESSON)->pluck('id'),
                "courses"           => $product->categories->where('type', ProductCategoryType::COURSE)->pluck('id'),
            ];
        }


        return response()->json([
            'data' => $products_array
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
