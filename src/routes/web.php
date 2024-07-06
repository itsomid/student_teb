<?php


use App\DTO\StudentAccount\ChargeAccountDTO;
use App\Enums\DepositTypeEnum;
use App\Services\ChargeAccountService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Services\PaymentGateway\Gateway;
use App\Models\GatewayTransaction;
use App\Services\PaymentGateway\Exception\RetryException;
use Illuminate\Http\Response;

use App\Services\PaymentGateway\Exception\InvalidRequestException;
use App\Services\PaymentGateway\Exception\NotFoundTransactionException;
Route::view('/', 'welcome');


//TODO:: REFACTOR AND REPLACE THIS CODES TO CONTROLLER

Route::view('/bank' , 'bank.bank');

Route::get('/go_to_gateway', function (){
    try {
        $gateway= \App\Services\PaymentGateway\Gateway::initial();
        $gateway->setCallback('/callback_from_gateway');
        $gateway->price(request()->input('price'))->ready();
        return $gateway->redirect();
    }catch (Exception $exception){
        return  view('bank.bank')->with('error_message' , $exception->getMessage());
    }
});



Route::any('/callback_from_gateway', function () {


    try {
        if (request()->has('transaction_id')) {
            $id = request()->get('transaction_id');
            $transaction = GatewayTransaction::find($id);
        } else {
            throw new InvalidRequestException();
        }

        if (!$transaction) {
            throw new NotFoundTransactionException();
        }

        if (in_array($transaction->status, ['SUCCEED', 'FAILED'])) {
            throw new RetryException();
        }

        $gateway = Gateway::initial();
        $gateway->verify($transaction);

        $chargeAccountService = resolve(ChargeAccountService::class);
        $chargeAccountService->charge(
            (new ChargeAccountDTO())
            ->setDepositType(DepositTypeEnum::BUY)
            ->setUserId($transaction->user_id)
            ->setAmount($transaction->price)
        );

        // Refresh the transaction instance
        $transaction->refresh();

        DB::beginTransaction();
        try {
            $orderService = resolve(OrderService::class);
            $order = $orderService->buy($transaction->user_id);

            DB::commit();
            return view('bank.callback', ['transaction' => $transaction, 'order_id' => $order->id]);
        } catch (Throwable $e) {
            Log::channel('payment')->info('Error in inner try block:', ['exception' => $e]);
            DB::rollBack();
            return view('bank.callback')->with('error_message', 'مشکلی در فرآیند خرید شما پیش آمده است. لطفا با پشتیبانی تماس بگیرید.');
        }
    } catch (RetryException $exception) {
        Log::channel('payment')->error('RetryException caught:', ['exception' => $exception]);
        return view('bank.callback')->with('error_message', $exception->getMessage());
    } catch (InvalidRequestException | NotFoundTransactionException $exception) {
        Log::channel('payment')->error('Request or Transaction Exception caught:', ['exception' => $exception]);
        return view('bank.callback')->with('error_message', $exception->getMessage());
    } catch (Throwable $exception) {
        Log::channel('payment')->error('Error in outer try block:', ['exception' => $exception]);
        return view('bank.callback')->with('error_message', 'An unexpected error occurred. Please contact support.');
    }
});
