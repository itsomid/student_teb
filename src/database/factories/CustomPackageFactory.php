<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section_name' => fake()->text(100),
        ];
    }
}
