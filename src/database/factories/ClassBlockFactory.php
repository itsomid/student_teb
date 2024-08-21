<?php

namespace Database\Factories;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassBlock>
 */
class ClassBlockFactory extends Factory
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
            'product_id' => Product::query()->where('product_type_id', ProductTypeEnum::CLASSES)->inRandomOrder()->first()->id,
            'description' => $this->faker->sentence,
            'expired_at' => $this->faker->randomElement([null, $this->faker->dateTime])
        ];
    }
}
