<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\DistributeStudents;
use Illuminate\Http\Request;

class RandomStudentsDistributionController extends Controller
{
    public function index()
    {
        $supports= Admin::query()->role('sales_support')->get();
        return view('dashboard.distribute_students.random.index')->with('supports', $supports);
    }

    public function distribute(Request $request)
    {
        $object= new DistributeStudents();
        $object->distribute($request->support_id);

        return redirect()->back();
    }
}
