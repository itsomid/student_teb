<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\Class\CreateRequest;
use App\Http\Requests\Class\UpdateRequest;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Course $course)
    {

        $classes= Classes::query()->where('course_id', $course->id)->with('product')->with('course')->get();

        return view('dashboard.class.index')
            ->with(['course'  => $course])
            ->with(['classes' => $classes]);
    }

    public function create(Course $course)
    {
        return view('dashboard.class.create')
            ->with(['course'  => $course]);
    }

    public function store(Course $course, CreateRequest $request)
    {

        $product= Product::query()->create([
            'parent_id'       => $course->product_id,
            'product_type_id' => ProductTypeEnum::CLASSES,
            'name'            => $request->name,
            'description'     => $request->description,
        ]);

        $class= Classes::query()->create([
            'product_id'             => $product->id,
            'course_id'              => $course->id,
            'holding_date'           => DateFormatter::format($request->holding_date),
            'status'                 => $request->status,
            'parent_id'              => $request->parent_id,
            'studio_description'     => $request->studio_description,
            'qa_is_active'           => $request->has('qa_is_active')          &&  $request->qa_is_active == 'on' ? true : false,
            'homework_is_active'     => $request->has('homework_is_active')    &&  $request->homework_is_active == 'on' ? true : false,
            'homework_is_mandatory'  => $request->has('homework_is_mandatory') &&  $request->homework_is_mandatory == 'on' ? true : false,
            'report_is_mandatory'    => $request->has('report_is_mandatory')   &&  $request->report_is_mandatory == 'on' ? true : false,
            'is_free'                => $request->has('is_free')               &&  $request->is_free == 'on' ? true : false,
            'offline_link_woza'      => $request->offline_link_woza,
            'offline_link_vod'       => $request->offline_link_vod,
            'emergency_link'         => $request->emergency_link,
            'attached_file_link'     => $request->attached_file_link,
        ]);

        Toast::message('کلاس با موفقیت ایجاد شد')->notify();
        return redirect()->route('admin.classes.index', ['course' => $course->id]);
    }

    public function edit(Course $course, Classes $classes)
    {
        $class= Classes::query()->where('id', $classes->id)->with('product')->with('course')->firstOrFail();
        return view('dashboard.class.edit')
            ->with('class' , $class)
            ->with('course', $course);
    }

    public function update(Course $course, Classes $classes, UpdateRequest $request)
    {
        $product = Product::query()->where('id', $classes->product_id)->first()->update([
            'name'            => $request->name,
            'description'     => $request->description,
        ]);


        $classes->update([
            'holding_date'           => DateFormatter::format($request->holding_date),
            'status'                 => $request->status,
            'parent_id'              => $request->parent_id,
            'studio_description'     => $request->studio_description,
            'qa_is_active'           => $request->has('qa_is_active')          &&  $request->qa_is_active == 'on' ? true : false,
            'homework_is_active'     => $request->has('homework_is_active')    &&  $request->homework_is_active == 'on' ? true : false,
            'homework_is_mandatory'  => $request->has('homework_is_mandatory') &&  $request->homework_is_mandatory == 'on' ? true : false,
            'report_is_mandatory'    => $request->has('report_is_mandatory')   &&  $request->report_is_mandatory == 'on' ? true : false,
            'is_free'                => $request->has('is_free')               &&  $request->is_free == 'on' ? true : false,
            'offline_link_woza'      => $request->offline_link_woza,
            'offline_link_vod'       => $request->offline_link_vod,
            'emergency_link'         => $request->emergency_link,
            'attached_file_link'     => $request->attached_file_link,
        ]);

        Toast::message('کلاس با موفقیت ویرایش شد')->notify();
        return redirect()->route('admin.classes.index', ['course' => $course->id]);
    }
}
