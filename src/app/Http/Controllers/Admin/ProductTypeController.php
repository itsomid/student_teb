<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;


class ProductTypeController extends Controller
{
    public function index()
    {
        $product_types= ProductTypeEnum::TYPE_LABEL;
        return view('dashboard.product.type.index')
            ->with(['product_types' => $product_types]);
    }
}
