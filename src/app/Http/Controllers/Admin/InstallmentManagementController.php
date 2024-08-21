<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstallmentRepayment;
use Illuminate\Http\Request;

class InstallmentManagementController extends Controller
{
    public function index()
    {
        $installments= InstallmentRepayment::query()
            ->with('user')
            ->with('order_item')
            ->filterBy(request()->all())
            ->latest()
            ->paginate(50);

        return view('dashboard.installment.index')->with('installments', $installments);
    }
}
