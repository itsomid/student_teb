<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ReferralCode;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralCodeController extends Controller
{
    public function index()
    {
        $admins = Admin::query()->has('referralCodes')->select('id', 'first_name', 'last_name')->get();

        $referralCodes = ReferralCode::query()->filterBy(request()->all())->with('admin')->withCount('registered_users')->get();

        return view('dashboard.referral_code.index')
            ->with(['referralCodes' => $referralCodes])
            ->with(['admins' => $admins]);
    }

    public function create()
    {
        $admins = Admin::salesSupportAndSupervisor()->select('id', 'first_name', 'last_name', 'mobile')->get();


        return view('dashboard.referral_code.create')
            ->with(['admins' => $admins]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required'],
            'gift_credit' => ['required'],
            'sale_support_id' => ['required', 'numeric'],
        ]);

        $admin = Admin::query()->findOrFail($request->sale_support_id);
        $admin->referralCodes()->create([
            'code' => $request->code,
            'gift_credit' => $request->gift_credit,
        ]);

        Toast::message('کد معرف با موفقیت ایجاد شد')->success()->notify();
        return redirect()->route('admin.referral_code.index');
    }

    public function edit(ReferralCode $referralCode)
    {
        $admins = Admin::salesSupportAndSupervisor()->select('id', 'first_name', 'last_name', 'mobile')->get();
        return view('dashboard.referral_code.edit')
            ->with(['referralCode' => $referralCode])
            ->with(['admins' => $admins]);
    }

    public function update(ReferralCode $referralCode, Request $request)
    {
        $request->validate([
            'code' => ['required'],
            'gift_credit' => ['required'],
            'sale_support_id' => ['required', 'numeric'],
        ]);

        $referralCode->update([
            'code' => $request->code,
            'gift_credit' => $request->gift_credit,
            'admin_id' => $request->sale_support_id,
        ]);

        Toast::message('کد معرف با موفقیت ویرایش شد')->success()->notify();
        return redirect()->route('admin.referral_code.index');
    }
}
