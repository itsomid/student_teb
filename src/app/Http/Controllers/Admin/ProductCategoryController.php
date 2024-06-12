<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductCategoryType;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $product_categories= Category::all();
        return view('dashboard.product.category.index')->with(['product_categories' => $product_categories]);
    }

    public function create()
    {
        return view('dashboard.product.category.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => ['required'],
            'type' => ['required', Rule::enum(ProductCategoryType::class)]
        ]);

        Category::store([
            'name' => $request->name,
            'type' => $request->type
        ]);

        Toast::message('دسته بندی با موفقیت ایجاد شد')->success()->notify();
        return redirect()->route('admin.product_category.index');
    }

    public function edit(Category $product_category)
    {
        return view('dashboard.product.category.edit')->with(['product_category' => $product_category]);
    }

    public function update(Category $product_category, Request $request)
    {
        $this->validate($request, [
            'name'  => ['required'],
            'type' => ['required']
        ]);

        $product_category->update([
            'name' => $request->name,
            'type' => $request->type
        ]);

        Toast::message('دسته بندی با موفقیت ویرایش شد')->success()->notify();
        return redirect()->back();
    }

    public function destroy(Category $product_category)
    {
        $product_category->delete();

        Toast::message('دسته بندی با موفقیت حذف شد')->success()->notify();
        return redirect()->route('admin.product_category.index');
    }
}
