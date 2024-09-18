<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 50), // Assume 100 orders
            'product_id' => $this->faker->numberBetween(1, 100), // Assume 100 products
            'final_price' => $finalPrice = $this->faker->randomElement([$this->faker->numerify('#000000'), $this->faker->numerify('##00000'), $this->faker->numerify('###00000')]),
            'final_price_without_vat' => $finalPrice - ($finalPrice * 0.1),
            'product_price' => $this->faker->randomElement([$this->faker->numerify('#000000'), $this->faker->numerify('##00000'), $this->faker->numerify('###00000')]),
            'discount_price' => $this->faker->randomElement([0, 0, $this->faker->numerify('#0000')]),
            'user_gift_amount' => $this->faker->randomElement([10000, 500000, 0, 300000, 0]),
        ];
    }
}
