<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherPayments>
 */
class TeacherPaymentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numerify("##000000"), //10000000, 15000000, 2000000
            'description' => $this->faker->sentence,
            'receipt_image' => null,
            'transaction_time' => $this->faker->time
        ];
    }
}
