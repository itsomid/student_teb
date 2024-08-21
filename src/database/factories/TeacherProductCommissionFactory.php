<?php

namespace Database\Factories;

use App\Enums\ProductTypeEnum;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherProductCommission>
 */
class TeacherProductCommissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_percentage' => $this->faker->numberBetween(1, 80),
            'tax_block_percentage' => 10,
            'teacher_id' => Admin::query()->inRandomOrder()->first()->id,
            'product_id' => Product::query()->where('product_type_id', ProductTypeEnum::COURSE)->inRandomOrder()->first()->id,
        ];
    }
}
