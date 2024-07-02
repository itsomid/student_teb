<?php

namespace App\Services;

use App\DTO\StudentAccount\ChargeAccountDTO;
use App\Enums\DepositTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class ChargeAccountService
{
    public function charge(ChargeAccountDTO $DTO): void
    {
        $transaction = Transaction::query()->create([
            'amount' => $DTO->getAmount(),
            'user_id' => $DTO->getUserId(),
            'user_description' => $DTO->getUserDescription(),
            'transaction_type' => TransactionTypeEnum::DEPOSIT
        ]);

        $transaction->deposit()->create([
            'deposit_type' => $DTO->getIsGift() ? DepositTypeEnum::Gift : DepositTypeEnum::Admin,
            'user_id' => $DTO->getUserId(),
            'admin_id' => $DTO->getAdminId()
        ]);

        Account::deposit($DTO->getUserId(), $DTO->getAmount());
    }
}
