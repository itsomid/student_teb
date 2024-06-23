<?php

namespace App\Listeners;

use App\Enums\TransactionTypeEnum;
use App\Events\OrderCreated;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveTransactionListener
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
        //TODO
        Transaction::query()->create([
            'amount' => $event->order->total_payable_price,
            'user_id' => $event->order->user_id,
            'transaction_type' => TransactionTypeEnum::BUY
        ]);
    }
}
