<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Course;
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
            Course::factory()->count(1)
        )->create();

        foreach ($products as $product)
            Product::factory(10)->class()->classname()->has(Classes::factory(1)->course_id($product->course))->create();

    }
}
