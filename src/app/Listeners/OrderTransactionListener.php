<?php

namespace App\Listeners;

use App\Enums\DepositTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Events\OrderCreated;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderTransactionListener
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
        $user = User::find($event->order->user_id);
        Transaction::query()->create([
            'amount' => $event->order->total_payable_price,
            'user_id' => $user->id,
            'transaction_type' => TransactionTypeEnum::BUY
        ]);

        Transaction::query()->create([
            'amount' => $event->order->vat_tax,
            'user_id' => $user->id,
            'transaction_type' => TransactionTypeEnum::VAT_TAX
        ]);


        if ($event->order->total_discount > 0){
            Transaction::query()->create([
                'amount' => $event->order->total_discount,
                'user_id' => $event->order->user_id,
                'transaction_type' => TransactionTypeEnum::DISCOUNT
            ]);
        }
    }
}
