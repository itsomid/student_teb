<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CommissionType;
use App\Models\SupportsAllocationRate;
use Illuminate\Http\Request;

class SupportsAllocationRateController extends Controller
{
    public function edit()
    {
        $elementary_supports= CommissionType::getElementarySupports()->pluck('support_id')->toArray();

        $sale_supports= Admin::query()->role('sales_support')->with('roles')->with('allocationRate')->get();
        return view('dashboard.supports_allocation_rate.edit')
            ->with('elementary_supports', $elementary_supports)
            ->with('sale_supports', $sale_supports);
    }

    public function update(Request $request)
    {
        $sale_supports= Admin::query()->role('sales_support')->with('roles')->with('allocationRate')->get();
        $allocation_rates= SupportsAllocationRate::query()->get();


        foreach ($sale_supports as $sale_support)
        {
            //تو جدولی که ضریب ها هست، ضریب این پشتیبان را بگیر
            $previewsAllocationRate= $allocation_rates->where('sale_support_id', $sale_support->id)->first();

            //اگر برای این پشتیبان ضریب پخش وارد شده بود
            if (   isset($request->allocation_rate[$sale_support->id])
                && isset($request->is_active[$sale_support->id])
                && $request->is_active[$sale_support->id] == 'on'
            )
            {
                //اگر برای این پشتیبان ضریب پخش در جدول مربوطه وجود داشت و اگر ضریب پخش وارد شده با ضریب پخش قبلی یکسان نبود ادیت کن
                if ($previewsAllocationRate
                    && ((int)$previewsAllocationRate->allocation_rate != (int)$request->allocation_rate[$sale_support->id]
                        || $previewsAllocationRate->is_active != (bool)$request->is_active[$sale_support->id]))
                {
                    $allocation_rates->where('sale_support_id', $sale_support->id)->first()->update([
                        'allocation_rate' => $request->allocation_rate[$sale_support->id],
                        'is_active'       => true,
                    ]);
                }elseif(!$previewsAllocationRate){
                    //اگر ضریب پخش وجود نداشت در جدول مربوطه ایجاد کن
                    SupportsAllocationRate::query()->create([
                        'sale_support_id' => $sale_support->id,
                        'allocation_rate' => $request->allocation_rate[$sale_support->id],
                        'is_active'       => true,
                    ]);
                }
            }else{
                //اگر کلا برای این پشتیبان ضریب پخش وارد نشده بود، یعنی باید در جدول مربوطه غیر فعال شود:
                $rate = $allocation_rates->where('sale_support_id', $sale_support->id)->first();
                if ($rate){
                    $rate->update([
                        'is_active'       => false,
                    ]);
                }else{
                    SupportsAllocationRate::query()->create([
                        'sale_support_id' => $sale_support->id,
                        'allocation_rate' => 1,
                        'is_active'       => false,
                    ]);
                }
            }
        }


        Toast::message('تغییرات با موفقیت انجام شد')->success()->notify();
        return redirect()->back();
    }
}
