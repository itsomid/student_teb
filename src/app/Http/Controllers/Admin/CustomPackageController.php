<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomPackage\CreateCustomPackageRequest;
use App\Models\CustomPackage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function edit(Product $product)
    {
        $categories = Category::query()->get();
        return view('dashboard.custom_package.edit', compact('categories', 'product'));
    }
    public function create()
    {
        $categories = Category::query()->get();
        return view('dashboard.custom_package.create', compact('categories'));
    }

    public function store(CreateCustomPackageRequest $request)
    {
        $input = $request->all();

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
                'options' => ['fake_price' => $input['options']['fake_price'], 'full_price_show' =>  $input['options']['full_price_show']],
                'is_purchasable' => array_key_exists('is_purchasable', $input),
                'has_installment' => array_key_exists('has_installment', $input),
                'show_in_list' => array_key_exists('show_in_list', $input),
                'installment_count' => $input['installment_count'],
                'first_installment_ratio' => $input['first_installment_ratio'],
                'first_installment_amount'  => $input['first_installment_amount'],
                'final_installment_date' => $input['final_installment_date'],
                'holding_date' => isset($input['holding_date']) ? DateFormatter::format($input['holding_date']) : null
            ]);

            $sections = $request->sections;
            $data = [];

            foreach($sections as $section) {
                $section = json_decode($section);
                $data['product_id'] = $new_product->id;
                $data['section_name'] = $section->title;

                $package = CustomPackage::query()->create($data);
                foreach ($section->courses as $course) {
                    $package->items()->create([
                        'product_id' => $course->id
                    ]);
                }
            }
            if (isset($input['categories']) && $input['categories']) {
                $new_product->product_categories()->sync($input['categories']);
            }

            Toast::message('پکیج سفارشی با موفقیت ایجاد شد.')->success()->notify();
            DB::commit();
            return redirect(route('admin.custom-package.index'));
        }catch (Throwable $e){
            report($e);
            DB::rollBack();
            Toast::message('ساخت پکیج سفارشی با شکست مواجه شد.')->danger()->notify();
            return redirect(route('admin.custom-package.index'));

        }

    }

    public function update(Product $product, Request $request)
    {
        $input = $request->all();

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
                'options' => ['fake_price' => $input['options']['fake_price'], 'full_price_show' =>  $input['options']['full_price_show']],
                'is_purchasable' => array_key_exists('is_purchasable', $input),
                'has_installment' => array_key_exists('has_installment', $input),
                'show_in_list' => array_key_exists('show_in_list', $input),
                'installment_count' => $input['installment_count'],
                'first_installment_ratio' => $input['first_installment_ratio'],
                'first_installment_amount'  => $input['first_installment_amount'],
                'final_installment_date' => $input['final_installment_date'],
                'holding_date' => isset($input['holding_date']) ? DateFormatter::format($input['holding_date']) : null
            ]);
            $product->packages()->delete();


            $sections = $request->sections;
            $data = [];

            foreach($sections as $section) {
                $section = json_decode($section);
                $data['product_id'] = $product->id;
                $data['section_name'] = $section->title;
                $package = $product->packages()->create($data);

                $package->items()->delete();
                foreach ($section->courses as $course) {
                    $package->items()->create([
                        'product_id' => $course->id
                    ]);
                }
            }
            if (isset($input['categories']) && $input['categories']) {
                $product->product_categories()->sync($input['categories']);
            }

            Toast::message('پکیج سفارشی با موفقیت ویرایش شد.')->success()->notify();
            DB::commit();
            return redirect(route('admin.custom-package.index'));
        }catch (Throwable $e){
            report($e);
            dd($e->getMessage());
            DB::rollBack();
            Toast::message('ویرایش پکیج سفارشی با شکست مواجه شد.')->danger()->notify();
            return redirect(route('admin.custom-package.index'));

        }
    }
}
