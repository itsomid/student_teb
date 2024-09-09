<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;

class TeacherCommissionController extends Controller
{
    public function calculate(Admin $teacher): View
    {
        $products = Product::query()
            ->where('user_id', $teacher->id)
            ->whereIn('product_type_id', [ProductTypeEnum::COURSE, ProductTypeEnum::CUSTOM_PACKAGE])
            ->with('teacher_commission')
            ->withSum('order_items', 'final_price')
            ->withCount('order_items')
            ->withSum('cash_amounts', 'cash_amount')
            ->get();

        $my_sum_arr = [];
        foreach($products as $product) {
            $my_sum_arr[$product->id] = [
                'students' => $product->order_items_count,
                'buy_amount' => $product->order_items_sum_final_price,
                'cash_amount' => $product->cash_amounts_sum_cash_amount,
                'payments_amount' => 0,
                'tax_blocked' => ((int)$product->cash_amounts_sum_cash_amount ? $product->cash_amounts_sum_cash_amount / 100: 0) * ($product->teacher_commission->tax_block_percentage ?? 30),
            ];
        }

        return view('dashboard.teacher_commission.calculate', compact('products', 'teacher', 'my_sum_arr'));
    }
}
