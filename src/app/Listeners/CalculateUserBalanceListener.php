<?php

namespace App\Listeners;

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateUserBalanceListener
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
    public function handle(object $event): void
    {

        $user = User::find($event->order->user_id);

        // Calculate the sum of the balance
        $sumOfBuy = Transaction::where('user_id', $user->id)
            ->where('transactionType', TransactionTypeEnum::BUY)
            ->sum('balance');

        $account = static::query()
            ->firstOrCreate(['user_id' => $user->id], [
                'balance' => 0,
                'gift_amount' => 0,
                'withdrawal_amount' => 0
            ]);

        $account->balance -= $sumOfBuy;
        $account->save();

    }
}
