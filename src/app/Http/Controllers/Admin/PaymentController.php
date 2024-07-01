<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\IncreaseCreditRequest;
use App\Models\Transaction;
use App\Services\PaymentGateway\Exception\InvalidRequestException;
use App\Services\PaymentGateway\Exception\NotFoundTransactionException;
use App\Services\PaymentGateway\Exception\RetryException;
use App\Services\PaymentGateway\Gateway;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class PaymentController extends Controller
{

    public function increaseCreditForm()
    {
        return view('dashboard.payment.increase-credit');
    }

    public function increaseCredit(IncreaseCreditRequest $request)
    {
        $amount = $request->input('amount');

    }
}
