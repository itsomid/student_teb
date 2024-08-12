<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionHistory;
use App\Models\CommissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionHistoryManagementController extends Controller
{
    public function index($commission)
    {
        $commission= Commission::query()->withTrashed()->where('id', $commission)->firstOrFail();

        $histories= CommissionHistory::query()
            ->with('type')
            ->where('commission_id' , $commission->id)
            ->latest()
            ->get();


        return view('dashboard.commission.history.index')
            ->with('commission' , $commission)
            ->with('histories' , $histories);
    }

    public function create($commission)
    {
        $commission= Commission::query()->withTrashed()->where('id', $commission)->firstOrFail();
        $types= CommissionType::query()->orderBy('percentage', 'DESC')->get();

        return view('dashboard.commission.history.create')
            ->with('types' , $types)
            ->with('commission' , $commission);
    }

    public function store(Request $request, $commission)
    {

        $this->validate($request,[
            'percentage' => ['numeric', 'min:0' , 'max:0.6', 'required']
        ]);
        $created_at   = DateFormatter::format($request->created_at);

        $commission= Commission::query()->withTrashed()->where('id', $commission)->with('histories')->firstOrFail();


        $history= $commission->histories()->create([
            'changed_by' => auth('admin')->id(),
            'type_id'    => $request->type,
            'percentage' => $request->percentage,
            'description'=> Commission::ACTIONS[$request->action]['description'],
            'theme'      => Commission::ACTIONS[$request->action]['theme'],
        ]);


        $history->created_at = $created_at;
        $history->save();

        return redirect()->route('commission.history.index', ['commission' => $commission->id]);
    }

    public function edit(Commission $commission, CommissionHistory $history)
    {
        return view('dashboard.commission.history.edit')
            ->with('commission', $commission)
            ->with('history', $history);
    }

    public function update($commission, $history, Request $request)
    {
        $this->validate($request,[
            'created_at' => ['required']
        ]);

        $created_at= DateFormatter::format($request->created_at);

        DB::table('commission_histories')->where('id', $history)->update([
            'created_at' => (string)$created_at
        ]);

        return redirect()->back()->with('success_message', "تغییرات با موفقیت صورت گرفت");
    }
}
