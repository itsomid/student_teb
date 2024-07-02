<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CouponExport;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Helpers\PanelConditions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CreateRequest;
use App\Http\Requests\Coupon\UpdateRequest;
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
        $coupons = \App\Models\Coupon::query()->with('creator_user')->latest()->get();

        return (request()->input('action') == 'search' or is_null(request()->input('action')))
                ? view('dashboard.coupon.index')->with(['coupons' => $coupons])
                : Excel::download(new CouponExport($coupons), Jalalian::now()->format('%A_ %d %B %Y').'__'.'coupons.xlsx');
    }

    public function create()
    {
        $courses= Course::query()->select(['id','product_id'])->latest()->with('product')->get();
        return view('dashboard.coupon.create')->with(['courses' => $courses]);
    }

    public function store(CreateRequest $request)
    {
        $input = $request->all();

        $input['creator_user_id'] = auth('admin')->id();

        if ($request->discount_amount) {
            $input['discount_amount'] = str_replace(",", "", $input['discount_amount']);
        }

        $input['expired_at']= DateFormatter::format($request->expired_at);

        if (auth('admin')->user()->cannot('coupons.coupons.all.data') && auth('admin')->user()->cannot('coupon.product.section')) {
            $conditions_array["product_atleast_count"] = "1";
            // $conditions_array["product"] = $discount_range['conditions_products_ids'];
            $conditions_array["product_atleast_one"] = null;
            $conditions_array["product_bought_atleast_count"] = null;
            $conditions_array["profile"]["grade"] = null;
            $input['conditions'] = json_encode($conditions_array);

        } else {
            $input['conditions'] = PanelConditions::createConditionsJSON($request);
        }


        //It is specified whether one coupon or several are to be created.
        $codeCount = (array_key_exists('coupon-count', $input) && $input['coupon-count']) ? intval($input['coupon-count']) : 1;

        if ($codeCount === 1) {
            $request->validate(['coupon' => ['required',    Rule::unique('coupons', 'coupon')->whereNull('deleted_at')]]);
            $input['coupon'] = strtolower($input['coupon']);
            $input['is_mass'] = false;

            //This condition executes when we intend to create one coupon for a group of students
            if (request()->input('is_multiple') == 1 && request()->has('ids')) {
                foreach (json_decode(request()->input('ids')) as $user_id) {
                    $input['consumer_user_id'] = $user_id;
                    Coupon::query()->create($input);
                }
                Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
                return redirect()->route('admin.coupons.index');
            }

            Coupon::query()->create($input);
            Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
            return redirect()->route('admin.coupons.index');
        }

        for ($i = 0; $i < $codeCount; $i++) {
            /*
             * If the coupon code already exists (isCodeExist returns true), the loop repeats, generating a new
             * coupon code and checking again. This process continues until a unique coupon code is generated
             * (one that does not exist in the database).
             */
            do {
                $input['coupon'] = strtolower(Str::random(8));
                $input['is_mass'] = true;
            } while ( Coupon::query()->isCodeExist($input['coupon']));

            Coupon::query()->create($input);
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

    public function update($coupon, UpdateRequest $request)
    {
        $coupons= Coupon::query()->where('id', $coupon)->first();

        $input = $request->all();

        if ($request->discount_amount) {
            $input['discount_amount'] = str_replace(",", "", $input['discount_amount']);
        }

        if (! auth('admin')->user()->can('coupons.coupons.all.data') && ! auth('admin')->user()->can('coupon.product.section')) {
            $conditions_array["product_atleast_count"] = $request->product_atleast_count;
            //$conditions_array["product"] = $discount_range['conditions_products_ids'];
            $conditions_array["product_atleast_one"] = $request->product_atleast_one ;
            $conditions_array["product_bought_atleast_count"] = $request->product_bought_atleast_count ;
            $conditions_array["profile"]["grade"] = $request->conditions_profile['grade'];
            $input['conditions'] = $conditions_array;

        } else {
            $input['conditions'] = PanelConditions::createConditionsJSON($request);
        }

        $coupons->coupon              = $input['coupon'];
        $coupons->conditions          = $input['conditions'];
        $coupons->description         = $input['description'];
        $coupons->consumer_user_id    = $input['consumer_user_id'];
        $coupons->discount_percentage = $input['discount_percentage'];
        $coupons->creator_user_id     = auth('admin')->user()->id;
        $coupons->expired_at          = DateFormatter::format($input['expired_at']);

        if (isset($request->specific_product_id)) {
            $coupons->specific_product_id = $input['specific_product_id'];
        }
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
            $coupons->for_old_users         = $input['for_old_users'];
            $coupons->for_old_users_min_pay = $input['for_old_users_min_pay'];
        }

        $coupons->save();

        Toast::message('کد تخفیف ویرایش شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete($coupon);
        Toast::message('حذف کد تخفیف با موفقیت انجام شد')->warning()->notify();
        return redirect()->route('admin.coupons.index');
    }

    public function excel()
    {
        $coupons= Coupon::excel();
        return Excel::download(new CouponExport($coupons), 'coupons.xlsx');
    }
}
