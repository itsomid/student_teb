<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DepositTypeEnum;
use App\Enums\TransactionTypeEnum;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAccount\ChargeAccountRequest;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class StudentAccountController extends Controller
{

    public function chargeForm()
    {
        return view('dashboard.student-account.charge-account');
    }

    public function chargeAccount(ChargeAccountRequest $request)
    {
        $input = $request->validated();

        try{
            DB::beginTransaction();
            $transaction = Transaction::query()->create([
                'amount' => $input['amount'],
                'user_id' => $input['user_id'],
                'user_description' => $input['user_description'],
                'transaction_type' => TransactionTypeEnum::DEPOSIT
            ]);

            $transaction->deposit()->create([
                'deposit_type' => array_key_exists('gift_credit', $input) ? DepositTypeEnum::Gift : DepositTypeEnum::Admin,
                'user_id' => $input['user_id'],
                'admin_id' => Auth::guard('admin')->id()
            ]);

            Account::deposit($input['user_id'], $input['amount']);
            DB::commit();
            Toast::message('افزایش اعتبار با موفقیت انجام شد')->success()->notify();
        }catch (Throwable $e) {
            report($e);
            DB::rollBack();
            Toast::message('عملیات افزایش اعتبار با شکست خورد.')->danger()->notify();
        }

        return back();
    }
}
