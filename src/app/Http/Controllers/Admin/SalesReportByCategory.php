<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SalesReportByCategory extends Controller
{
    public function index()
    {
        $categories= Category::query()->active()->orderBy('type')->get();
        return view('dashboard.sales_report_by_category.index')->with('categories',$categories);
    }
}
