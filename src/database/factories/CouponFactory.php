<?php

namespace Database\Factories;

use App\Data\Grades;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creator_user_id' => fake()->numberBetween(1, 11),
            'consumer_user_id' => Arr::random([null, null, fake()->numberBetween(1, 11)]),
            'specific_product_id' => fake()->numberBetween(1, 10),
            'discount_percentage' => fake()->numberBetween(1, 100),
            'coupon' => fake()->unique()->colorName(),
            'discount_amount' => fake()->numberBetween(1000, 50000),
            'description' => fake()->sentence,
            'is_disposable' => fake()->boolean,
            'is_multiuser' =>fake()->boolean,
            'for_old_users' => fake()->boolean,
            'number_of_use' => fake()->numberBetween(0, 50),
            'conditions' => $this->getConditions()
        ];
    }

    private function getConditions(): array
    {
        $productLimit = rand(1, 10);

        return [
            'product_atleast_count' => $productLimit,
            'product' => Product::select('id')->inRandomOrder()->limit($productLimit)->get()->pluck('id')->toArray(),
            'product_atleast_one' => fake()->boolean,
            'product_bought_atleast_count' => $productLimit,
            'profile' => ['grade' => Arr::random(Grades::getIndex())]
        ];
    }
}
