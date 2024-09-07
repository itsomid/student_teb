<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Admin;
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
            'sales_support_id' => Admin::query()->role('sales_support')->first()->id,
            'vat_tax' => $vat = $this->faker->numberBetween(1,3)* 1000, // VAT as a percentage
            'total_payable_price' => $price = $this->faker->numberBetween(1,3) * 100000,
            'final_price' => $vat+$price,
            'total_discount' => $this->faker->numberBetween(1,3) * 10000,
            'repayment_count' => $this->faker->numberBetween(1, 12),
            'status' => $this->faker->randomElement(array_column(OrderStatusEnum::cases(), 'value'))
        ];
    }
}
