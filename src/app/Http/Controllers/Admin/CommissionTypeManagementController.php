<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionType;
use Illuminate\Http\Request;

class CommissionTypeManagementController extends Controller
{
    public function index()
    {
        $types= CommissionType::query()->withTrashed()->orderBy('deleted_at', 'ASC')->get();
        return view('dashboard.commissions_type.index')->with('types', $types);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'percentage' => 'numeric'
        ]);

        CommissionType::query()->create([
            'title'         => $request->title,
            'percentage'    => $request->percentage,
        ]);

        return redirect()->route('admin.commission_type.index')->with('success_message', "نوع همکاری با موفقیت اضافه شد.");
    }

    public function edit($commissionType)
    {
        $type= CommissionType::query()->where('id', $commissionType)->withTrashed()->firstOrFail();
        return view('dashboard.commissions_type.edit')->with('type', $type);
    }


    public function update(Request $request, $commissionType)
    {
        $this->validate($request, [
            'title' => 'required',
            'percentage' => 'numeric'
        ]);

        $type= CommissionType::query()->where('id', $commissionType)->withTrashed()->firstOrFail();

        if ($request->percentage != $type->percentage)
            CommissionType::setLogForCommissionsOnUpdate($type, $request->percentage);

        $type->update([
            'title'         => $request->title,
            'percentage'    => $request->percentage,
        ]);

        return redirect()->back()->with('success_message', "نوع همکاری با موفقیت ویرایش شد.");
    }


    public function destroy($commissionType)
    {
        $commissionType= CommissionType::query()->withTrashed()->where('id', $commissionType)->firstOrFail();

        $action= is_null($commissionType->deleted_at)
            ? 'حذف'
            : 'بازیابی';

        is_null($commissionType->deleted_at)
            ? $commissionType->delete()
            : $commissionType->restore();


        return redirect()->back()->with('danger_message', "{$action} با موفقیت اعمال شد");
    }
}
