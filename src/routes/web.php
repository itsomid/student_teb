<?php

use Illuminate\Support\Facades\Route;

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


Route::any('/callback_from_gateway', function (){
    if (!request()->has('transaction_id'))
        throw new \App\Services\PaymentGateway\Exception\InvalidRequestException();

    if (request()->has('transaction_id'))
        $id = request()->get('transaction_id');

    $transaction = \Illuminate\Support\Facades\DB::table('gateway_transactions')->where('id', $id)->first();

    if (!$transaction)
        throw new \App\Services\PaymentGateway\Exception\NotFoundTransactionException();


    if (in_array($transaction->status, ['SUCCEED', 'FAILED']))
        throw new \App\Services\PaymentGateway\Exception\RetryException();

    try {
        $gateway = \App\Services\PaymentGateway\Gateway::initial();

        $gateway = $gateway->verify($transaction);
    }catch (Exception $exception){
        return view('bank.callback')->with('error_message', $exception->getMessage());
    }
    return view('bank.callback');
});
