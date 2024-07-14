<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CouponCondition\CouponConditionDTO;
use App\Enums\CouponTypesEnum;
use App\Enums\ProductCategoryType;
use App\Enums\ProductTypeEnum;
use App\Exports\CouponExport;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Helpers\PanelConditions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CreateRequest;
use App\Http\Requests\Coupon\SpecifiedStudentsCouponRequest;
use App\Http\Requests\Coupon\conditionalStudentDiscountRequest;
use App\Http\Requests\Coupon\storeMassCreationRequest;
use App\Http\Requests\Coupon\UpdateRequest;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;


class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::query()->filterBy(request()->all())->latest()->get();
        //TODO :: Export Excel
        return view('dashboard.coupon.index')->with(['coupons' => $coupons]);
    }

    public function createSpecifiedStudentsCoupon()
    {
        $products= Product::query()
            ->whereIn('product_type_id',[ProductTypeEnum::COURSE, ProductTypeEnum::PACKAGE, ProductTypeEnum::CUSTOM_PACKAGE])
            ->latest()
            ->get();

        return view('dashboard.coupon.create_specified_students_coupon')->with(['products' => $products]);
    }
    public function storeSpecifiedStudentsCoupon(SpecifiedStudentsCouponRequest $request)
    {
        $request->validate([
            'coupon' =>  Rule::unique('coupons')
        ]);

        Coupon::query()->create([
            'type'                  => CouponTypesEnum::SPECIFIED_STUDENTS_COUPON,
            'creator_id'            => auth('admin')->id(),
            'consumer_ids'          => array_map('intval', $request->consumer_ids),
            'coupon'                => strtolower($request->coupon),
            'description'           => $request->description,
            'discount_percentage'   => $request->discount_percentage,
            'discount_amount'       => (int)Str::remove(',', $request->discount_amount),
            'expired_at'            => DateFormatter::format($request->expired_at),
            'product_ids'           => array_map('intval', $request->product_ids ?? []),
            'is_one_time'           => (boolean)$request->is_one_time
        ]);

        Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }


    public function createMassCreation()
    {
        $products= Product::query()
            ->whereIn('product_type_id',[ProductTypeEnum::COURSE, ProductTypeEnum::PACKAGE, ProductTypeEnum::CUSTOM_PACKAGE])
            ->latest()
            ->get();
        return view('dashboard.coupon.create_mass_creation')->with(['products' => $products]);
    }

    public function storeMassCreation(storeMassCreationRequest $request)
    {

        $postfix= ' #'.Str::upper(Str::random(6));

        for ($i = 0; $i<= $request->count; $i++){

            do {
                $code = strtolower(Str::random(8));
            } while ( Coupon::query()->where('coupon', $code)->exists());

            Coupon::query()->create([
                'type'                  => CouponTypesEnum::MASS_CREATION,
                'creator_id'            => auth('admin')->id(),
                'coupon'                => $code,
                'description'           => $request->description . $postfix,   //we add postfix for emergency situations.
                'discount_percentage'   => $request->discount_percentage,
                'discount_amount'       => $request->discount_amount,
                'expired_at'            => DateFormatter::format($request->expired_at),
                'product_ids'           => array_map('intval', $request->product_ids ?? []),
                'is_one_time'           => true
            ]);
        }

        Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }



    public function createConditionalStudentDiscount()
    {
        $products= Product::query()
            ->whereIn('product_type_id',[ProductTypeEnum::COURSE, ProductTypeEnum::PACKAGE, ProductTypeEnum::CUSTOM_PACKAGE])
            ->latest()
            ->get();
        return view('dashboard.coupon.create_conditional_student_discount')->with(['products' => $products]);
    }
    public function storeConditionalStudentDiscount(ConditionalStudentDiscountRequest $request)
    {
        $request->validate([
            'coupon' =>  Rule::unique('coupons')
        ]);

        $conditions= (new CouponConditionDTO())
            ->setForLastYearStudents((bool)$request->for_last_year_students)
            ->setLastYearMinimumPurchase($request->last_year_minimum_purchase)
            ->setPurchasesStatus($request->purchases_status)
            ->setPurchasedItems($request->purchased_items ?? [])
            ->setCartItemsCount($request->cart_items_count)
            ->setSpecifiedCartItems($request->specified_cart_items ?? [])
            ->setGrade($request->grade)
            ->setFieldOfStudy($request->field_of_study);

        Coupon::query()->create([
            'type'                  => CouponTypesEnum::CONDITIONAL_STUDENT_DISCOUNT,
            'creator_id'            => auth('admin')->id(),
            'coupon'                => strtolower($request->coupon),
            'description'           => $request->description,
            'discount_percentage'   => $request->discount_percentage,
            'discount_amount'       => $request->discount_amount,
            'expired_at'            => DateFormatter::format($request->expired_at),
            'product_ids'           => array_map('intval', $request->product_ids ?? []),
            'is_one_time'           => (boolean)$request->is_one_time,
            'conditions'            => $conditions->getObject()
        ]);

        Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }






    public function edit(Coupon $coupon)
    {
        $products= Product::query()
            ->whereIn('product_type_id',[ProductTypeEnum::COURSE, ProductTypeEnum::PACKAGE, ProductTypeEnum::CUSTOM_PACKAGE])
            ->latest()
            ->get();

        $bladeMap=[
            'SPECIFIED_STUDENTS_COUPON'    => view('dashboard.coupon.edit_specified_students_coupon')   ->with('coupon', $coupon),
            'CONDITIONAL_STUDENT_DISCOUNT' => view('dashboard.coupon.edit_conditional_student_discount')->with('coupon', $coupon),
        ];

        return $bladeMap[$coupon->type]->with('products' , $products);
    }


    public function updateSpecifiedStudentsCoupon(Coupon $coupon, SpecifiedStudentsCouponRequest $request)
    {
        $request->validate([
            'coupon' =>  Rule::unique('coupons')->ignore($coupon->id),
        ]);

        $coupon->update([
            'consumer_ids'          => array_map('intval', $request->consumer_ids),
            'coupon'                => strtolower($request->coupon),
            'description'           => $request->description,
            'discount_percentage'   => $request->discount_percentage,
            'discount_amount'       => $request->discount_amount,
            'expired_at'            => DateFormatter::format($request->expired_at),
            'product_ids'           => array_map('intval', $request->product_ids ?? []),
            'is_one_time'           => (boolean)$request->is_one_time
        ]);

        Toast::message('کد تخفیف با موفقیت ویرایش شد')->success()->notify();
        return redirect()->route('admin.coupons.index');
    }

    public function updateConditionalStudentDiscount(Coupon $coupon, ConditionalStudentDiscountRequest $request)
    {
        $request->validate([
            'coupon' =>  Rule::unique('coupons')->ignore($coupon->id),
        ]);
        $conditions= (new CouponConditionDTO())
            ->setForLastYearStudents((bool)$request->for_last_year_students)
            ->setLastYearMinimumPurchase($request->last_year_minimum_purchase)
            ->setPurchasesStatus($request->purchases_status)
            ->setPurchasedItems($request->purchased_items ?? [])
            ->setCartItemsCount($request->cart_items_count)
            ->setSpecifiedCartItems($request->specified_cart_items ?? [])
            ->setGrade($request->grade?? [])
            ->setFieldOfStudy($request->field_of_study?? []);

        $coupon->update([
            'coupon'                => strtolower($request->coupon),
            'description'           => $request->description,
            'discount_percentage'   => $request->discount_percentage,
            'discount_amount'       => $request->discount_amount,
            'expired_at'            => DateFormatter::format($request->expired_at),
            'product_ids'           => array_map('intval', $request->product_ids ?? []),
            'is_one_time'           => (boolean)$request->is_one_time,
            'conditions'            => $conditions->getObject()
        ]);

        Toast::message('کد تخفیف با موفقیت ایجاد شد')->success()->notify();
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
