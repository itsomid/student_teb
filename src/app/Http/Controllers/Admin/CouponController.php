<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CouponExport;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;
use function React\Promise\all;

class CouponController extends Controller
{
    public function index()
    {

        $coupons = \App\Models\Coupon::query()->latest()->get();

        return (request()->input('action') == 'search' or is_null(request()->input('action')))
                ? view('dashboard.coupon.index')->with(['coupons' => $coupons])
                : Excel::download(new CouponExport($coupons), Jalalian::now()->format('%A_ %d %B %Y').'__'.'coupons.xlsx');
    }

    public function create()
    {
        $courses= Course::query()->latest()->all();
        return view('dashboard.coupon.create')->with([

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'consumer_user_id'                  => ['required'],
            'specific_product_id'               => ['required'],
            'discount_percentage'               => ['nullable', 'numeric', 'required_without:discount_amount'],
            'discount_amount'                   => ['nullable', 'numeric', 'required_without:discount_percentage'],
            'for_old_users'                     => ['nullable', 'boolean'],
            'for_old_users_min_pay'             => ['required', 'required_if:for_old_users,1'],
            'coupon'                            => ['nullable'],
            'expired_at'                        => ['nullable', 'date'],
            'coupon_count'                      => ['nullable', 'numeric'],
            'product_atleast_count'             => ['nullable', 'numeric'],
            'product_atleast_one'               => ['nullable', 'in:0,1'],
            'product_bought_atleast_count'      => ['nullable', 'numeric'],
            'conditions_products_ids'           => ['nullable', 'array'],
            'conditions_products_bought_ids'    => ['nullable', 'array'],
            'conditions_profile'                => ['nullable', 'array'],
            'is_multiuser'                      => ['nullable', 'boolean'],
            'is_disposable'                     => ['nullable', 'boolean'],
            'has_purchased'                     => ['nullable', 'in:0,1,2'],
            'description'                       => ['nullable']
        ]);

        Coupon::query()->create([
            'creator_user_id'                   => auth()->id(),
            'consumer_user_id'                  => $request->consumer_user_id,
            'specific_product_id'               => $request->specific_product_id,
            'discount_percentage'               => $request->discount_percentage,
            'discount_amount'                   => $request->discount_amount,
            'for_old_users'                     => $request->for_old_users,
            'for_old_users_min_pay'             => $request->for_old_users_min_pay,
            'coupon'                            => $request->coupon,
            'expired_at'                        => DateFormatter::format($request->expired_at),
            'coupon-count'                      => $request->coupon_count,
            'permission_add_condition'          => auth()->user()->can('coupons.set.condition'),
            'product_atleast_count'             => $request->product_atleast_count,
            'product_atleast_one'               => $request->product_atleast_one,
            'product_bought_atleast_count'      => $request->product_bought_atleast_count,
            'conditions_products_ids'           => $request->conditions_products_ids,
            'conditions_products_bought_ids'    => $request->conditions_products_bought_ids,
            'conditions_profile'                => $request->conditions_profile,
            'is_multiuser'                      => $request->is_multiuser,
            'is_disposable'                     => $request->is_disposable,
            'has_purchased'                     => $request->has_purchased,
            'description'                       => $request->description,
        ]);

        Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }

    public function edit($coupon)
    {
        $coupon= Coupon::query()->where('id', $coupon)->first();
        return view('dashboard.coupon.edit')
            ->with(['coupon' => $coupon]);
    }

    public function update($coupon, Request $request)
    {
        $coupon= Coupon::show($coupon);

        $request->validate([
            'consumer_user_id'                  => ['required'],
            'specific_product_id'               => ['required'],
            'discount_percentage'               => ['nullable', 'numeric', 'required_without:discount_amount'],
            'discount_amount'                   => ['nullable', 'numeric', 'required_without:discount_percentage'],
            'for_old_users'                     => ['nullable', 'boolean'],
            'for_old_users_min_pay'             => ['required', 'required_if:for_old_users,1'],
            'coupon'                            => ['nullable'],
            'expired_at'                        => ['nullable', 'date'],
            'coupon_count'                      => ['nullable', 'numeric', 'min:1'],
            'product_atleast_count'             => ['nullable', 'numeric'],
            'product_atleast_one'               => ['nullable', 'in:0,1'],
            'product_bought_atleast_count'      => ['nullable', 'numeric'],
            'conditions_products_ids'           => ['nullable', 'array'],
            'conditions_products_bought_ids'    => ['nullable', 'array'],
            'conditions_profile'                => ['nullable', 'array'],
            'is_multiuser'                      => ['nullable', 'boolean'],
            'is_disposable'                     => ['nullable', 'boolean'],
            'has_purchased'                     => ['nullable', 'in:0,1,2'],
            'description'                       => ['nullable']
        ]);

        Coupon::update($coupon->id ,[
            'creator_user_id'                   => auth()->id(),
            'consumer_user_id'                  => $request->consumer_user_id,
            'specific_product_id'               => $request->specific_product_id,
            'discount_percentage'               => $request->discount_percentage,
            'discount_amount'                   => $request->discount_amount,
            'for_old_users'                     => $request->for_old_users,
            'for_old_users_min_pay'             => $request->for_old_users_min_pay,
            'coupon'                            => $request->coupon,
            'expired_at'                        => DateFormatter::format($request->expired_at),
            'permission_add_condition'          => auth()->user()->can('coupons.set.condition'),
            'product_atleast_count'             => $request->product_atleast_count,
            'product_atleast_one'               => $request->product_atleast_one,
            'product_bought_atleast_count'      => $request->product_bought_atleast_count,
            'conditions_products_ids'           => $request->conditions_products_ids,
            'conditions_products_bought_ids'    => $request->conditions_products_bought_ids,
            'conditions_profile'                => $request->conditions_profile,
            'is_multiuser'                      => $request->is_multiuser,
            'is_disposable'                     => $request->is_disposable,
            'has_purchased'                     => $request->has_purchased,
            'description'                       => $request->description,
        ]);
        Toast::message('کد تخفیف ویرایش شد')->success()->notify();
        return redirect()->back();
    }

    public function destroy($coupon)
    {
        Coupon::delete($coupon);
        Toast::message('حذف کد تخفیف با موفقیت انجام شد')->warning()->notify();
        return redirect()->route('admin.coupons.index');
    }

    public function excel()
    {
        $coupons= Coupon::excel();
        return Excel::download(new CouponExport($coupons), 'coupons.xlsx');
    }

}
