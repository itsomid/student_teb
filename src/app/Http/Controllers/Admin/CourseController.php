<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CreateRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Throwable;


class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::query()->with('product')->filterBy(request()->all())->get();
        return view('dashboard.course.index')
            ->with(['courses' => $courses]);
    }

    public function create()
    {
        $types= ProductTypeEnum::TYPE_LABEL;
        $categories= Category::query()->get();
        return view('dashboard.course.create')
            ->with(['categories' => $categories])
            ->with(['types' => $types]);
    }

    public function store(CreateRequest $request)
    {
        $imageName = time().'.'.$request->img_filename->extension();
        $request->img_filename->move(public_path('images/Courses'), $imageName);

        DB::beginTransaction();
        try {
            $product = Product::query()->create([
                'product_type_id'           => $request->product_type_id,
                'user_id'                   => $request->user_id,
                'name'                      => $request->name,
                'description'               => $request->description,
                'original_price'            => $request->original_price,
                'off_price'                 => $request->off_price,
                'options'                   => $request->options,
                'sort_num'                  => $request->sort_num,
                'img_filename'              => $imageName,
                'subscription_start_at'     => DateFormatter::format($request->subscription_start_at),
                'installment_count'         => $request->installment_count,
                'first_installment_ratio'   => $request->first_installment_ratio,
                'final_installment_date'    => DateFormatter::format($request->final_installment_date),
                'expiration_duration'       => $request->expiration_duration,
                'is_purchasable'            => $request->has('is_purchasable'),
                'has_installment'           => $request->has('has_installment'),
                'show_in_list'              => $request->has('show_in_list'),
            ]);

            $product->categories()->attach($request->categories);

            $product->course()->create([
                'qa_status'                 => $request->has('qa_status'),
                'about_course'              => $request->about_course,
                'start_date'                => $request->start_date,
            ]);
            DB::commit();
            Toast::message('دوره با موفقیت ایجاد شد')->success()->notify();
        }catch (Throwable $e){
            report($e);
            DB::rollBack();
            Toast::message('ساخت دوره با شکست مواجه شد لطفا مجددا تلاش کنید')->danger()->notify();
        }

        return redirect()->route('admin.course.index');
    }

    public function edit(Course $course)
    {
         $types= ProductTypeEnum::TYPE_LABEL;
        $categories= Category::query()->get();

        return view('dashboard.course.edit')
            ->with(['types'      => $types])
            ->with(['categories' => $categories])
            ->with(['course'     => $course]);
    }

    public function update(Course $course, UpdateRequest $request)
    {
        $imageName= $course->product->img_filename;
        $oldImage = null;
        if ($request->hasFile('img_filename'))
        {
            $oldImage = $imageName;
            $imageName = time().'.'.$request->img_filename->extension();
            $request->img_filename->move(public_path('images/Courses'), $imageName);
        }

        DB::beginTransaction();
        try{
            $course->update([
                'start_date'                => $request->start_date,
                'about_course'              => $request->about_course,
                'qa_status'                 => $request->has('qa_status'),
            ]);
            $course->product->categories()->sync($request->categories);
            $course->product()->update([
                'product_type_id'           => $request->product_type_id,
                'user_id'                   => $request->user_id,
                'name'                      => $request->name,
                'description'               => $request->description,
                'original_price'            => $request->original_price,
                'off_price'                 => $request->off_price,
                'options'                   => $request->options,
                'sort_num'                  => $request->sort_num,
                'img_filename'              => $imageName,
                'subscription_start_at'     => DateFormatter::format($request->subscription_start_at),
                'installment_count'         => $request->installment_count,
                'first_installment_ratio'   => $request->first_installment_ratio,
                'final_installment_date'    => DateFormatter::format($request->final_installment_date),
                'expiration_duration'       => $request->expiration_duration,
                'is_purchasable'            => $request->has('is_purchasable'),
                'has_installment'           => $request->has('has_installment'),
                'show_in_list'              => $request->has('show_in_list'),
            ]);
            DB::commit();
            Toast::message('دوره با موفقیت ویرایش شد')->success()->notify();

        }catch (Throwable $e){
            report($e);
            DB::rollBack();
            Toast::message('ویراش دوره شکست خورد')->danger()->notify();
        }

        if ($oldImage){
            unlink(public_path('images/Courses') . '/' .$oldImage);
        }
        return redirect()->back();
    }
}
