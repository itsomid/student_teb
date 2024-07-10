<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 4), // Assume 50 users
            'vat_tax' => $this->faker->numberBetween(1,3)* 1000, // VAT as a percentage
            'total_payable_price' => $this->faker->numberBetween(1,3) * 100000,
            'total_discount' => $this->faker->numberBetween(1,3) * 10000,
            'installment_total_amount' => $this->faker->numberBetween(1,3),
            'repayment_count' => $this->faker->numberBetween(1, 12),
            'status' => $this->faker->randomElement(array_column(OrderStatusEnum::cases(), 'value'))
        ];
    }
}
