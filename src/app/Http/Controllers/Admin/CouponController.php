<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CouponExport;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Helpers\PanelConditions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CreateRequest;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;


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
        $courses= Course::query()->latest()->with('product')->get();
        return view('dashboard.coupon.create')->with([
            'courses' => $courses
        ]);
    }

    public function store(CreateRequest $request)
    {
        if (!$request->filled('discount_percentage') && !$request->filled('discount_amount')) {
            return redirect()->back();
        }
        if ($request->filled('discount_percentage') && $request->filled('discount_amount')) {
            return redirect()->back();
        }


        if (!auth('admin')->user()->can('coupons_all_data')) {
            $discount_range = ['start_discount_range' => 2 , 'end_discount_range' => 10]; //Most Be Dynamic
            if ($request->discount_percentage < $discount_range['start_discount_range'] || $request->discount_percentage > $discount_range['end_discount_range'])
            {
                return redirect()->back();
            }
        }
        $input = $request->all();

        if ($request->discount_amount) {
            $input['discount_amount'] = str_replace(",", "", $input['discount_amount']);
        }

        $input['creator_user_id'] = auth()->id();

        if (!auth('admin')->user()->can('coupons_all_data') && !auth('admin')->user()->can('coupon_product_section')) {
            $conditions_array["product_atleast_count"] = "1";
            //$conditions_array["product"] = $discount_range['conditions_products_ids'];
            $conditions_array["product_atleast_one"] = null;
            $conditions_array["product_bought_atleast_count"] = null;
            $conditions_array["profile"]["grade"] = null;
            $input['conditions'] = json_encode($conditions_array);

        } else {
            $input['conditions'] = PanelConditions::createConditionsJSON($request);
        }

        $input['expired_at']= DateFormatter::format($request->expired_at);

        $codeCount = (array_key_exists('coupon-count', $input) && $input['coupon-count']) ? intval($input['coupon-count']) : 1;
        if ($codeCount === 1) {
            $request->validate(['coupon' => [
                'required',
                Rule::unique('coupons', 'coupon')->whereNull('deleted_at')
            ]]);
            $input['coupon'] = strtolower($input['coupon']);
            $input['is_mass'] = false;
            if (request()->input('is_multiple') == 1 && request()->has('ids')) {

                foreach (json_decode(request()->input('ids')) as $user_id) {
                    $input['consumer_user_id'] = $user_id;
                    Coupon::query()->create($input);
                }
            } else {
                Coupon::query()->create($input);
            }
        } else {
            for ($i = 0; $i < $codeCount; $i++) {
                do {
                    $input['coupon'] = Str::random(8);
                    $input['is_mass'] = true;
                } while ( Coupon::query()->isCodeExist($input['coupon']));

                Coupon::query()->create($input);
            }
        }

        Toast::message('کد تخفیف ویرایش شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }

    public function edit($coupon)
    {
        $courses= Course::query()->latest()->with('product')->get();
        $coupon= Coupon::query()->where('id', $coupon)->first();
        return view('dashboard.coupon.edit')
            ->with(['coupon' => $coupon])
            ->with(['courses' => $courses]);
    }

    public function update($coupon, Request $request)
    {
        $coupons= Coupon::query()->where('id', $coupon)->first();


        if (!$request->filled('discount_percentage') && !$request->filled('discount_amount')) {
            return redirect()->back();
        }
        if ($request->filled('discount_percentage') && $request->filled('discount_amount')) {
            return redirect()->back();
        }


        if (!auth('admin')->user()->can('coupons_all_data')) {
            $discount_range = ['start_discount_range' => 2 , 'end_discount_range' => 10]; //Most Be Dynamic
            if ($request->discount_percentage < $discount_range['start_discount_range'] || $request->discount_percentage > $discount_range['end_discount_range'])
            {
                return redirect()->back();
            }
        }
        $input = $request->all();

        if ($request->discount_amount) {
            $input['discount_amount'] = str_replace(",", "", $input['discount_amount']);
        }

        $input['creator_user_id'] = auth()->id();


        if (! auth('admin')->user()->can('coupons_all_data') && ! auth('admin')->user()->can('coupon_product_section')) {
            $conditions_array["product_atleast_count"] = "1";
//            $conditions_array["product"] = $discount_range['conditions_products_ids'];
            $conditions_array["product_atleast_one"] = null;
            $conditions_array["product_bought_atleast_count"] = null;
            $conditions_array["profile"]["grade"] = null;
            $input['conditions'] = json_encode($conditions_array);

        } else {
            $input['conditions'] = PanelConditions::createConditionsJSON($request);
        }
        //$coupons = $this->couponsRepository->update($request->all(), $id);

        $coupons->creator_user_id = \Auth::user()->id;
        $coupons->coupon = $input['coupon'];
        $coupons->consumer_user_id = $input['consumer_user_id'];
        if (isset($request->specific_product_id)) {
            $coupons->specific_product_id = $input['specific_product_id'];
        }

        $coupons->discount_percentage = $input['discount_percentage'];
        $coupons->expired_at = DateFormatter::format($input['expired_at']);
        $coupons->conditions = $input['conditions'];
        $coupons->description = $input['description'];
        if (isset($request->has_purchased)) {
            $coupons->has_purchased = $input['has_purchased'];
        }
        if (isset($request->is_disposable)) {
            $coupons->is_disposable = $input['is_disposable'];
        }
        if (isset($request->is_multiuser)) {
            $coupons->is_multiuser = $input['is_multiuser'];
        }
        if (isset($request->for_old_users)) {
            $coupons->for_old_users = $input['for_old_users'];
            $coupons->for_old_users_min_pay = $input['for_old_users_min_pay'];
        }

        $coupons->save();

        Toast::message('کد تخفیف ویرایش شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
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
