<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => $this->getProductId(),
            'start_date' => 'اواسط مرداد',
            'about_course' => fake()->sentence(),
            'qa_status' => fake()->boolean,
        ];
    }

    public function getProductId(): int
    {
        $ids = Course::query()->select('product_id')->get()->pluck('product_id');
        return Product::query()->whereNotIn('id', $ids)->first()->id;
    }
}
