<?php

namespace App\Listeners;

use App\DTO\StudentAccount\ChargeAccountDTO;
use App\Enums\DepositTypeEnum;
use App\Services\ChargeAccountService;

class ChargeStudentAccountOnPaymentSuccessListener
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
        $transaction = $event->gatewayTransaction;

        $chargeAccountService = resolve(ChargeAccountService::class);
        $chargeAccountService->charge(
            (new ChargeAccountDTO())
                ->setDepositType(DepositTypeEnum::BUY)
                ->setUserId($transaction->user_id)
                ->setAmount($transaction->price)
        );
    }
}
