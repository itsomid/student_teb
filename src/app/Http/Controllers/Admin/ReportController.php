<?php

namespace App\Http\Controllers\Admin;

use App\ExternalServices\ReportService;
use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $classes= Classes::query()->with('course.product')->get();

        $filter=[
            'page'      => request()->input('page' , 1),
            'limit'     => 80,
        ];

        if (request()->has('user_id') &&  !is_null(request()->input('user_id')))
        {
            $filter['user_id']= request()->input('user_id');
        }

        if (request()->has('product_id') &&  !is_null(request()->input('product_id')))
        {
            $product= Product::query()->where('id', request()->input('product_id'))->with('class:product_id,id')->first();
            if ($product->product_type_id == 2)
                $filter['class_id'] = $product->class->id;

            if ($product->product_type_id == 1){
                $class_ids = Product::query()->where('parent_id', $product->id)->where('product_type_id', 2)->with('class:product_id,id')->get()->pluck('class.id')->toArray();
                $filter['class_id'] = $class_ids;
            }
        }

        $reports= ReportService::getAllReports($filter);


        return view('dashboard.reports.index')
            ->with('classes', $classes)
            ->with('reports', $reports);
    }

    public function setScore($id, Request $request)
    {
        $this->validate($request, [
            'score' => ['required']
        ]);

        ReportService::setScore($id, $request->input('score'));

        return redirect()->back();
    }

    public function destroy($id)
    {
        ReportService::deleteReport($id);
        return redirect()->back();
    }
}
