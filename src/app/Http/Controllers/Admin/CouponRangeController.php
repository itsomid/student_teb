<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Services\CouponRange;
use App\Services\Course;
use Illuminate\Http\Request;

class CouponRangeController extends Controller
{
    public function edit()
    {
        $courses= Course::index();
        $range= CouponRange::show();
        return view('dashboard.coupon.range.edit')
            ->with(['courses' => $courses])
            ->with(['range' => $range]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'start_discount' => ['required', 'numeric', 'min:0', 'max:99'],
            'end_discount'   => ['required', 'numeric', 'min:1', 'max:100'],
            'product_ids'    => ['array'],
        ]);

        CouponRange::update([
            'start_discount_range' => $request->start_discount,
            'end_discount_range'   => $request->end_discount,
            'product_ids'          => $request->product_ids,
        ]);


        Toast::message('تغییرات با موفقیت ثبت شد')->success()->notify();
        return redirect()->back();
    }
}
