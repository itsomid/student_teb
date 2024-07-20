<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomPackage\CreateRequest;
use App\Http\Requests\CustomPackage\UpdateRequest;
use App\Models\CustomPackage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CustomPackageController extends Controller
{
    public function index()
    {
        $packages = Product::query()
            ->with('packages')
            ->filterBy(request()->all())
            ->where('product_type_id', ProductTypeEnum::CUSTOM_PACKAGE)
            ->get();

        return view('dashboard.custom_package.index', compact('packages'));
    }


    public function create()
    {
        $courses = Product::query()
            ->where('product_type_id', ProductTypeEnum::COURSE)
            ->select('id', 'name', 'img_filename')
            ->get();
        $categories = Category::query()->get();
        return view('dashboard.custom_package.create', compact('categories','courses'));
    }

    public function store(CreateRequest $request)
    {
        $input = $request->validated();

        DB::beginTransaction();
        try{
            //create product
            $new_product=Product::create([
                'product_type_id' => ProductTypeEnum::CUSTOM_PACKAGE,
                'name' => $input['name'],
                'original_price' => $input['original_price'],
                'off_price' => $input['off_price'],
                'user_id' => $input['user_id'],
                'description' => $input['description'],
                'is_purchasable' => array_key_exists('is_purchasable', $input),
                'has_installment' => array_key_exists('has_installment', $input),
                'show_in_list' => array_key_exists('show_in_list', $input),
                'installment_count' => $input['installment_count'],
                'first_installment_ratio' => $input['first_installment_ratio'],
                'first_installment_amount'  => $input['first_installment_amount'],
                'final_installment_date' => isset($request->final_installment_date) ? DateFormatter::format($request->final_installment_date) : null,
                'subscription_start_at' => isset($input['subscription_start_at']) ? DateFormatter::format($input['subscription_start_at']) : null
            ]);

            $sections = $request->sections;
            $data = [];

            foreach($sections as $section) {
                $data['product_id'] = $new_product->id;
                $data['section_name'] = $section['title'];

                $package = CustomPackage::query()->create($data);
                foreach ($section['courses'] as $course) {
                    $package->items()->create([
                        'product_id' => $course['id']
                    ]);
                }
            }
            if (isset($input['categories']) && $input['categories']) {
                $new_product->product_categories()->sync($input['categories']);
            }

            if($request->hasFile('img_filename')){
                $timestamp = now()->timestamp;
                $imageName = $new_product->id . '_' . Str::random(5) . '_' . $timestamp . '.' . $request->file('img_filename')->getClientOriginalExtension();
                $request->file('img_filename')->storeAs('products', $imageName, ['disk' => 'public']);
                $new_product->update(['img_filename' => $imageName]);
            }

            Toast::message('پکیج سفارشی با موفقیت ایجاد شد.')->success()->notify();
            DB::commit();
            return redirect(route('admin.custom-package.index'));
        }catch (Throwable $e){
            report($e);
            DB::rollBack();
            Toast::message('ساخت پکیج سفارشی با شکست مواجه شد.')->danger()->notify();
            return redirect()->back()->with('error-message', $e->getMessage());

        }

    }
    public function edit(Product $product)
    {
        $courses = Product::query()
            ->where('product_type_id', ProductTypeEnum::COURSE)
            ->select('id', 'name', 'img_filename')
            ->get();
        $categories = Category::query()->get();
        return view('dashboard.custom_package.edit', compact('categories', 'product','courses'));
    }
    public function update(Product $product, UpdateRequest $request)
    {
        $input = $request->all();
        $oldImage = $product->img_filename;

        if($request->hasFile('img_filename')){
            $timestamp = now()->timestamp;
            $imageName = $product->id . '_' . Str::random(5) . '_' . $timestamp . '.' . $request->file('img_filename')->getClientOriginalExtension();
            $request->file('img_filename')->storeAs('products', $imageName, ['disk' => 'public']);
            $product->update(['img_filename' => $imageName]);
        }
        DB::beginTransaction();
        try{
            //create product
            $product->update([
                'product_type_id' => ProductTypeEnum::CUSTOM_PACKAGE,
                'name' => $input['name'],
                'original_price' => $input['original_price'],
                'off_price' => $input['off_price'],
                'user_id' => $input['user_id'],
                'description' => $input['description'],
                'options' => '',
                'is_purchasable' => array_key_exists('is_purchasable', $input),
                'has_installment' => array_key_exists('has_installment', $input),
                'show_in_list' => array_key_exists('show_in_list', $input),
                'installment_count' => $input['installment_count'],
                'first_installment_ratio' => $input['first_installment_ratio'],
                'first_installment_amount'  => $input['first_installment_amount'],
                'final_installment_date' => isset($request->final_installment_date) ? DateFormatter::format($request->final_installment_date) : null,
                'subscription_start_at' => isset($input['subscription_start_at']) ? DateFormatter::format($input['subscription_start_at']) : null
            ]);
            $product->packages()->delete();


            $sections = $request->sections;
            $data = [];

            foreach($sections as $section) {
                $data['product_id'] = $product->id;
                $data['section_name'] = $section['title'];
                $package = $product->packages()->create($data);

                $package->items()->delete();
                foreach ($section['courses'] as $course) {
                    $package->items()->create([
                        'product_id' => $course['id']
                    ]);
                }
            }
            if (isset($input['categories']) && $input['categories']) {
                $product->categories()->sync($input['categories']);
            }
            //TODO create save file function
            if ($request->hasFile('img_filename')) {
                $oldImagePath = 'products/' . $oldImage;
                if ($oldImage && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            Toast::message('پکیج سفارشی با موفقیت ویرایش شد.')->success()->notify();
            DB::commit();
            return redirect(route('admin.custom-package.index'));
        }catch (Throwable $e){
            report($e);
            DB::rollBack();
            Toast::message('ویرایش پکیج سفارشی با شکست مواجه شد.')->danger()->notify();
            return redirect()->back()->with('error-message', $e->getMessage());
        }
    }
}
