<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportByCategory extends Controller
{
    public function index()
    {
        $categories= Category::query()->active()->orderBy('type')->get();

        if(!request()->has('categories'))
            return view('dashboard.sales_report_by_category.index')->with('categories',$categories);


        $product_ids = DB::table('category_product')
            ->select('product_id')
            ->whereIn('category_id', request()->input('categories'))
            ->pluck('product_id')
            ->toArray();

        $products = Product::query()->select('id','name')->whereIn('id', $product_ids)->get();

        $totalPaidAmountByProduct = OrderItem::query()
            ->select('product_id',
                DB::raw('SUM(final_price) as total_price'),
                DB::raw('COUNT(order_id) as order_count')
            )
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->whereIn('product_id', $product_ids)
            ->groupBy('product_id')
            ->get();

        $categories= Category::query()->active()->orderBy('type')->get();

        return view('dashboard.sales_report_by_category.index')
            ->with('categories',$categories)
            ->with('products',$products)
            ->with('totalPaidAmountByProduct',$totalPaidAmountByProduct);
    }
}
