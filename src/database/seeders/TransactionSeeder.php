<?php

namespace Database\Seeders;

use App\Enums\DepositTypeEnum;
use App\Models\Deposit;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::factory()->count(100)->create();

        $deposit_transactions= Transaction::query()
            ->where('transaction_type', 'deposit')
            ->get();

        foreach($deposit_transactions as $transaction){
            Deposit::query()->create([
                'deposit_type'   =>  \Arr::random(DepositTypeEnum::cases()),
                'transaction_id' => $transaction->id,
            ]);
        }
    }
}
