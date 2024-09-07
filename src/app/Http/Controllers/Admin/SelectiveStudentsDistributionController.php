<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\DistributeStudents;
use Illuminate\Http\Request;

class SelectiveStudentsDistributionController extends Controller
{
    public function index()
    {
        $supports= Admin::query()->role('sales_support')->get();
        return view('dashboard.distribute_students.selective.index')->with('supports', $supports);
    }

    public function distribute(Request $request)
    {
        $this->validate($request, [
            'support_ids' => ['required', 'array'],
        ]);

        $object= new DistributeStudents();
        $object->owner($request->support_id)
            ->among($request->support_ids)
            ->description('distributed by '. auth('admin')->user()->fullname())
            ->do();


        return redirect()->back();
    }
}
