<?php

namespace App\Legacy\Listeners;

use App\Enums\DepositTypeEnum;
use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\CardTransaction;
use App\Models\Transaction;
use Carbon\Carbon;

class NexusSaveStudentDebitCard implements LegacyContract
{

    public function handle(object $data): void
    {
        $cardTransaction = CardTransaction::query()->where('student_id', $data->student_id)->where('tracking_code', $data->tracking_code)->first();

        $transactionId = null;
        if ((is_null($cardTransaction) || is_null($cardTransaction->transaction_id)) && property_exists($data, 'transaction')){
            $createdTransaction = Transaction::query()->create([
                'user_id' => $data->transaction->user_id,
                'amount' => $data->transaction->amount,
                'transaction_type' => 'deposit',
                'user_description' => $data->transaction->user_description
            ]);

            $createdTransaction->deposit()->create([
                'deposit_type' => DepositTypeEnum::Debit,
                'user_id' => $data->transaction->user_id,
            ]);
            $transactionId = $createdTransaction->id;
        }

        $cardTransaction = is_null($cardTransaction)
            ?  new CardTransaction()
            :  $cardTransaction;

        $cardTransaction->student_id = $data->student_id;
        $cardTransaction->transaction_id = $transactionId;
        $cardTransaction->tracking_code = $data->tracking_code;
        $cardTransaction->amount = $data->amount;
        $cardTransaction->status = $data->status;
        $cardTransaction->paid_date = Carbon::parse($data->paid_date)->isPast() && Carbon::now()->addYears(-10)->lte($data->paid_date) ? $data->paid_date: null;
        $cardTransaction->filename = $data->filename[0] ?? null;
        $cardTransaction->description = $data->description;
        $cardTransaction->created_at = $data->created_at;
        $cardTransaction->updated_at =$data->updated_at;


        $cardTransaction->save();
    }
}
