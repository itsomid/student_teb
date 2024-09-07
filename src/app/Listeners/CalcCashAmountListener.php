<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\CashAmount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalcCashAmountListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $orderItems = $event->order->items;
        foreach ($orderItems as  $item) {
            $item->cash_amount()->create([
                'student_id' => $item->user_id,
                'product_id' => $item->product_id,
                'cash_amount' => $item->final_price - $item->user_gift_amount,
                'agent_commission_amount' => 0,
            ]);
        }
    }
}
