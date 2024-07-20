<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Course;
use App\Models\CustomPackage;
use App\Models\CustomPackageItem;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(40)->create();

        $products= Product::factory(11)->course()->has(
            Course::factory()->count(1),
        )->create();

        //create package
        Product::factory(10)->package()->has(
            CustomPackage::factory()->count(3)->has(CustomPackageItem::factory()->count(3), 'items'), 'packages'
        )->create();

        foreach ($products as $product)
            Product::factory(10)->class()->state(['parent_id' => $product->id])->classname()->has(Classes::factory(1)->course_id($product->course))->create();

    }
}
