<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DepositTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\IncreaseCreditRequest;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionController extends Controller
{

    public function increaseCreditForm()
    {
        return view('dashboard.payment.increase-credit');
    }

    public function increaseCredit(IncreaseCreditRequest $request)
    {
        $amount = $request->input('amount');
        $userId = $request->input('user_id');
        try{
            DB::beginTransaction();
            $transaction = Transaction::query()->create([
                'amount' => $amount,
                'user_id' => $userId,
                'transaction_type' => TransactionTypeEnum::DEPOSIT
            ]);

            $transaction->deposit()->create([
                'deposit_type' => DepositTypeEnum::Admin,
                'user_id' => $userId,
                'admin_id' => Auth::guard('admin')->id()
            ]);

            Account::deposit($userId, $amount);
            DB::commit();
            Toast::message('افزایش اعتبار با موفقیت انجام شد')->success()->notify();
        }catch (Throwable) {
            DB::rollBack();
            Toast::message('عملیات افزایش اعتبار با شکست خورد.')->danger()->notify();
        }

        return back();
    }
}
