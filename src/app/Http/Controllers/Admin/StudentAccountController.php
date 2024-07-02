<?php

namespace App\Http\Controllers\Admin;

use App\DTO\StudentAccount\ChargeAccountDTO;
use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAccount\ChargeAccountRequest;
use App\Services\ChargeAccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class StudentAccountController extends Controller
{

    public function __construct(private readonly ChargeAccountService $chargeAccountService)
    {
    }

    public function chargeForm()
    {
        return view('dashboard.student-account.charge-account');
    }

    public function chargeAccount(ChargeAccountRequest $request)
    {
        $input = $request->validated();

        try{
            DB::beginTransaction();

            $this->chargeAccountService->charge(
                (new ChargeAccountDTO())
                ->setAdminId(Auth::guard('admin')->id())
                ->setIsGift(array_key_exists('gift_credit', $input))
                ->setUserDescription($input['user_description'])
                ->setUserId($input['user_id'])
                ->setAmount($input['amount'])
            );

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
