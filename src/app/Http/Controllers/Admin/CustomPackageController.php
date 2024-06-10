<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductTypeEnum;
use App\Functions\DateFormatter;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomPackage\CreateCustomPackageRequest;
use App\Http\Requests\SaveProductRequest;
use App\Models\CustomPackage;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCustomPackages;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomPackageController extends Controller
{
    public function index()
    {
        $packages = CustomPackage::query()->with('product')->get();

        return view('dashboard.custom_package.index', compact('packages'));
    }

    public function create()
    {
        $categories = ProductCategory::query()->get();
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
            ]);

            $sections = $request->sections;
            $data = [];

            foreach($sections as $section) {
                $section = json_decode($section);
                $data['product_id'] = $new_product->id;
                $data['section_name'] = $section->title;
                $data['holding_date'] = isset($input['holding_date']) ? DateFormatter::format($input['holding_date']) : null;
                $package = CustomPackage::query()->create($data);
                foreach ($section->courses as $course) {
                    $package->items()->create([
                        'product_id' => $course->id
                    ]);
                }
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
}
