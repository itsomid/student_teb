<?php

namespace App\Http\Controllers\Admin;

use App\ExternalServices\HomeworkService;
use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeworkController extends Controller
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
                $filter['class_id'] = array_values(array_unique($class_ids));
            }
        }

        $productInputData=['id' => $product->id ?? null, 'product_name'=> $product->name ?? null];
        $homeworks= HomeworkService::getAllHomeworks($filter);

        return view('dashboard.homework.index')
            ->with('classes', $classes)
            ->with('productInputData', $productInputData)
            ->with('homeworks', $homeworks);
    }

    public function setScore($id, Request $request)
    {
        $this->validate($request, [
            'score' => ['required']
        ]);

        HomeworkService::setScore($id, $request->input('score'));

        return redirect()->back();
    }

    public function destroy($id)
    {
        HomeworkService::deleteHomewrk($id);
        return redirect()->back();
    }
}
