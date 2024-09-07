<?php

namespace Database\Seeders;

use App\Models\CashAmount;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderItem::factory()
            ->has(
                CashAmount::factory()
                    ->count(1)
                    ->state(fn(array $attributes, OrderItem $orderItem) => [
                        'cash_amount' => $orderItem->final_price,
                        'agent_commission_amount' => 0
                    ]),
                'cash_amount'
            )
            ->count(200)
            ->create();
    }
}
