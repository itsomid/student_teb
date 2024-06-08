<?php

namespace App\Http\Controllers\API;

use App\Enums\DebitCardStatus;
use App\Http\Controllers\Controller;
use App\Services\DebitCard;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DebitCardTransactionController extends Controller
{
    public function updateStatus($debitCard,Request $request)
    {
        $this->validate($request, [
            'status'  => ['required', Rule::enum(DebitCardStatus::class)],
        ]);

        $debitCard= DebitCard::show($debitCard);


        $result= DebitCard::updateStatus($debitCard->id, [
            'status' => $request->status
        ]);

        return response()->json()->status(201);
    }
}
