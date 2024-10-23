<?php

namespace App\Legacy\Listeners;

use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\CardTransaction;

class NexusSaveStudentDebitCard implements LegacyContract
{

    public function handle(object $data): void
    {
        $cardTransaction = CardTransaction::query()->where('student_id', $data->student_id)->where('tracking_code', $data->tracking_code)->first();

        $cardTransaction = is_null($cardTransaction)
            ?  new CardTransaction()
            :  $cardTransaction;

        $cardTransaction->student_id = $data->student_id;
        $cardTransaction->transaction_id = $data->transaction_id;
        $cardTransaction->tracking_code = $data->tracking_code;
        $cardTransaction->amount = $data->amount;
        $cardTransaction->status = $data->status;
        $cardTransaction->paid_date = $data->paid_date;
        $cardTransaction->filename = $data->filename[0];
        $cardTransaction->description = $data->description;
        $cardTransaction->created_at = $data->created_at;
        $cardTransaction->updated_at =$data->updated_at;


        $cardTransaction->save();
    }
}
