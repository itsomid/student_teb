<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCommission\SaveCommissionPercentageRequest;
use App\Models\Admin;
use App\Models\Product;
use App\Models\TeacherCommissionChangeHistory;
use App\Models\TeacherPayments;
use App\Models\TeacherProductCommission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TeacherCommissionController extends Controller
{
    public function calculate(Admin $teacher): View
    {
        $products = Product::query()
            ->where('user_id', $teacher->id)
            ->whereIn('product_type_id', [ProductTypeEnum::COURSE, ProductTypeEnum::CUSTOM_PACKAGE])
            ->with('teacher_commission')
            ->withSum('teacher_payments', 'amount')
            ->withSum('order_items', 'final_price')
            ->withCount('order_items')
            ->withSum('cash_amounts', DB::raw('`cash_amount` - `agent_commission_amount`'))
            ->withSum('cash_amounts', 'agent_commission_amount')
            ->get();

        $payments = TeacherPayments::query()
            ->with('product:id,name')
            ->where('teacher_id', $teacher->id)
            ->select(DB::raw('SUM(amount) as sum_amount'), 'product_id')
            ->groupBy('product_id')
            ->get();

        $historyChanged = TeacherCommissionChangeHistory::query()
            ->with('admin_changed_by:id,first_name,last_name', 'product:id,name')
            ->where('teacher_id', $teacher->id)
            ->get();

        $teacherSoldProducts = [];
        foreach($products as $product) {
            $teacherSoldProducts[$product->id] = [
                'students' => $product->order_items_count,
                'buy_amount' => $product->order_items_sum_final_price,
                'cash_amount' => $product->cash_amounts_sum_cash_amount_agent_commission_amount,
                'payments_amount' => $product->teacher_payments_sum_amount,
                'tax_blocked' => ((int)$product->cash_amounts_sum_cash_amount_agent_commission_amount ? $product->cash_amounts_sum_cash_amount_agent_commission_amount / 100: 0) * ($product->teacher_commission->tax_block_percentage ?? 30),
            ];
        }

        $teacherPaymentsSettings = Cache::store('database')->get('teacher_payments_settings');
        if (!$teacherPaymentsSettings) {
            $teacherPaymentsSettings['product_checked'] = [];
        }

        return view('dashboard.teacher_commission.calculate', compact('products', 'teacher', 'teacherSoldProducts', 'payments', 'teacherPaymentsSettings', 'historyChanged'));
    }

    public function saveCommissionPercentage(Admin $teacher, SaveCommissionPercentageRequest $request): RedirectResponse
    {
        //We Get All The Settings That Has Stored In Cache
        $teacher_payments_settings = Cache::store('database')->get('teacher_payments_settings');

        $result = [];
        if ($teacher_payments_settings) {
            $result['product_checked'] = $teacher_payments_settings['product_checked'];
        } else {
            $result['product_checked'] = [];
        }
        $inputs = $request->validated();
        // Define product_checked In Result Array
        foreach ($inputs['product_checkbox_all'] as $key => $value) {
            $previousData = TeacherProductCommission::query()
                ->where('product_id', $key)
                ->firstOrCreate(
                    ['product_id' => $key],
                    [
                        'teacher_id' => $teacher->id,
                        'product_percentage' => $inputs['product_percentage'][$key],
                        'tax_block_percentage' => $inputs['tax_percentage'][$key]
                    ]
                );

            if($previousData->product_percentage != $inputs['product_percentage'][$key] || $previousData->tax_block_percentage != $inputs['tax_percentage'][$key]){
                TeacherCommissionChangeHistory::query()->create([
                    'product_percentage' => $previousData->product_percentage,
                    'tax_block_percentage' => $previousData->tax_block_percentage,
                    'changed_by' => Auth::guard('admin')->user()->id,
                    'teacher_id' => $teacher->id,
                    'product_id' => $key,
                ]);
            }

            if (in_array($value, $inputs['product_checked'])) {
                $result['product_checked'][$key] = $value;
            } else {
                if (in_array($value, $result['product_checked'])) {
                    unset($result['product_checked'][$key]);
                }
            }
        }
        // Define product_percentage In Result Array
        foreach ($inputs['product_percentage'] as $key => $value) {
            TeacherProductCommission::query()->where('product_id', $key)->update(['product_percentage' => $value]);
        }

        // Define tax_percentage In Result Array
        foreach ($inputs['tax_percentage'] as $key => $value) {
            TeacherProductCommission::query()->where('product_id', $key)->update(['tax_block_percentage' => $value]);
        }
        Cache::store('database')->forever('teacher_payments_settings', $result);

        return redirect()->back();
    }
}
