<?php

namespace Database\Factories;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashAmount>
 */
class CashAmountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => User::query()->inRandomOrder()->first()->id,
            'product_id' => Product::query()->inRandomOrder()->where('product_type_id', ProductTypeEnum::COURSE)->first()->id,
            'cash_amount' => $this->faker->randomElement([0, 10000, 40000, 500000, 800000, 100000000, 2000000]),
            'agent_commission_amount' => $this->faker->randomElement([0, 10000, 40000, 500000, 0, 0, 0])
        ];
    }
}
