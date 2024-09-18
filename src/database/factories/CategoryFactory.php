<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => fake()->word(),
            'type'      => fake()->randomElement(['course', 'lesson', 'grade']),
            'key'       => fake()->randomElement([fake()->word(), 'consulting_planning']),
            'archived'  => fake()->boolean()
        ];
    }
}
