<?php

use App\Services\OrderService;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\PackageItem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::get('testm', function () {
    CartAdaptor::init(1);
//   \App\ShoppingCart\CartAdaptor::addPackage(14, [9, 6, 2]);

    $items = CartAdaptor::getItems();
    dd($items[0]->packageItems, $items[0] instanceof PackageItem);

});


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
    $userId = 1;
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
        $gateway->verify($transaction);


        DB::beginTransaction();
        try{

            $orderService = resolve(OrderService::class);
            $orderService->buy($userId);
            DB::commit();
            return response([
                'message' => 'سفارش شما با موفقیت پرداخت شد'
            ]);
        }catch (Throwable $e){

            report($e);
            DB::rollBack();
            return response([
                'message' => 'مشکلی پیش آمده است لطفا بعدا تلاش کنید' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }catch (Throwable $exception){

        return view('bank.callback')->with('error_message', $exception->getMessage());
    }

});
