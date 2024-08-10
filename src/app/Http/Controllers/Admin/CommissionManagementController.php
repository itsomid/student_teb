<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Commission;
use App\Models\CommissionType;
use Illuminate\Http\Request;

class CommissionManagementController extends Controller
{
    public function index()
    {
        $commissions= Commission::query()->with('type')->with('support')
            ->orderBy('deleted_at', 'ASC')
            ->orderBy('type_id', 'ASC')
            ->withTrashed()->get();

        $supports=    Admin::query()->select(['id', 'first_name', 'last_name', 'mobile'])
//            ->role(['sales_support', 'sales_supervisor'])
            ->get();

        $types=CommissionType::query()->orderBy('percentage', 'DESC')->get();

        return view('dashboard.commission.index')
            ->with('types', $types)
            ->with('supports', $supports)
            ->with('commissions', $commissions);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'support_id' => ['required'],
            'type_id'    => ['required'],
        ]);

        if(Commission::query()->where('support_id', $request->support_id)->withTrashed()->exists())
            return redirect()->route('admin.commission.index')->with('danger_message', "این کاربر قبلا به لیست اضافه شده است.");

        Admin::query()
            ->where('id', $request->support_id)
//            ->role(['sales_support', 'sales_supervisor'])
            ->firstOrFail();

        $type= CommissionType::query()->findOrFail($request->type_id);

        $commission= Commission::query()->create([
            'support_id' => $request->support_id,
            'type_id'    => $request->type_id,
        ]);

        $all_data = [
            'changed_by'  => auth()->id(),
            'commission_id' => $commission->id,
            'type_id'     => $type->id,
            'percentage'  => $type->percentage,
            'description' => Commission::ACTIONS['TYPE_CHANGED']['description'],
            'theme'       => Commission::ACTIONS['TYPE_CHANGED']['theme'],
        ];

        //Add History Log
        $commission->histories()->create([
            'changed_by'  => auth('admin')->id(),
            'type_id'     => $type->id,
            'percentage'  => $type->percentage,
            'description' => Commission::ACTIONS['COLLABORATION_STARTED']['description'],
            'theme'       => Commission::ACTIONS['COLLABORATION_STARTED']['theme'],
            'all_data'    => json_encode($all_data)
        ]);

        return redirect()->route('admin.commission.index')->with('success_message', "کاربر با موفقیت اضافه شد.");
    }

    public function edit($commission)
    {
        $commission= Commission::query()->withTrashed()->where('id', $commission)->firstOrFail();
        $types=CommissionType::query()->orderBy('percentage', 'DESC')->get();
        return view('dashboard.commission.edit')
            ->with('types', $types)
            ->with('commission', $commission);
    }


    public function update(Request $request, $commission)
    {
        $this->validate($request, [
            'type_id' => ['required']
        ]);

        $commission= Commission::query()->withTrashed()->where('id', $commission)->firstOrFail();
        $type= CommissionType::query()->where('id', $request->type_id)->firstOrFail();

        $commission->update([
            'type_id' => $type->id
        ]);
        $all_data = [
            'changed_by'  => auth('admin')->id(),
            'commission_id' => $commission->id,
            'type_id'     => $type->id,
            'percentage'  => $type->percentage,
            'description' => Commission::ACTIONS['TYPE_CHANGED']['description'],
            'theme'       => Commission::ACTIONS['TYPE_CHANGED']['theme'],
        ];
        $commission->histories()->create([
            'changed_by'  => auth()->id(),
            'type_id'     => $type->id,
            'percentage'  => $type->percentage,
            'description' => Commission::ACTIONS['TYPE_CHANGED']['description'],
            'theme'       => Commission::ACTIONS['TYPE_CHANGED']['theme'],
            'all_data'    => json_encode($all_data)
        ]);

        return redirect()->back()->with('success_message', "تغییرات با موفقیت اعمال شد");
    }

    public function destroy($commission)
    {
        $commission= Commission::query()->withTrashed()->where('id', $commission)->with('type')->firstOrFail();

        $action= is_null($commission->deleted_at)
            ? 'DELETED'
            : 'RESTORED';

        $all_data = [
            'changed_by'  => auth('admin')->id(),
            'commission_id' => $commission->id,
            'type_id'     => $commission->type_id,
            'percentage'  => $commission->type->percentage,
            'description' => Commission::ACTIONS[$action]['description'],
            'theme'       => Commission::ACTIONS[$action]['theme'],
        ];

        $commission->histories()->create([
            'changed_by'  => auth('admin')->id(),
            'type_id'     => $commission->type_id,
            'percentage'  => $commission->type->percentage,
            'description' => Commission::ACTIONS[$action]['description'],
            'theme'       => Commission::ACTIONS[$action]['theme'],
            'all_data'    => json_encode($all_data)
        ]);

        is_null($commission->deleted_at)
            ? $commission->delete()
            : $commission->restore();

        return redirect()->back()->with('danger_message', " عملیات با موفقیت انجام شد");
    }
}
