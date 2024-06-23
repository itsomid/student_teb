<?php

namespace App\Http\Controllers\API;

use App\Helpers\Castle\Services\CartCastle;
use App\Helpers\PaymentGateway\Exception\GatewayException;
use App\Helpers\PaymentGateway\Exception\InvalidRequestException;
use App\Helpers\PaymentGateway\Exception\NotFoundTransactionException;
use App\Helpers\PaymentGateway\Exception\RetryException;
use App\Http\Controllers\Controller;
use App\Jobs\Builder\CastlePublishBuilder;
use App\Jobs\SMSCartPurchased;
use App\Models\CartReciept;
use App\Models\Transaction;
use App\Models\TransactionLogs;
use App\Services\OrderService;
use App\Services\PaymentGateway\Gateway;
use App\ShoppingCart\CartAdaptor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class BuyController extends Controller
{
    private string $redirectCartPath;


    public function __construct(private readonly OrderService $orderService)
    {
        $this->redirectCartPath = config('gateway.redirect_cart_path');
    }

    public function payCart()
    {
        $auth = Auth::guard('student');

        CartAdaptor::init($auth->id());

        $payableForBank = CartAdaptor::getPayableAmount() - $auth->user()->credit;

        if ($payableForBank <= 0){
            DB::beginTransaction();
            try{
                $this->orderService->buy($auth->id());
                DB::commit();
                return response([
                    'message' => 'سفارش با موفقیت انجام شد'
                ], Response::HTTP_CREATED);
            }catch (Throwable $e){
                report($e);
                DB::rollBack();
                return response([
                    'message' => 'مشکلی پیش آمده است لطفا بعدا تلاش کنید' . $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

        }

    }

    public function cartCallback()
    {
        try {
            if (!request()->has('transaction_id'))
                throw new InvalidRequestException;
            if (request()->has('transaction_id'))
                $id = request()->get('transaction_id');

            $transaction = DB::table('gateway_transactions')->where('id', $id)->first();

            if (!$transaction)
                throw new NotFoundTransactionException;


            if (in_array($transaction->status, ['SUCCEED', 'FAILED']))
                throw new RetryException;

            $gateway= Gateway::initialZarinpal();

            $gateway = $gateway->verify($transaction);

            $user_id= Cache::get($gateway->transactionId());

            Config::set('session.driver' , 'array');

            Auth::loginUsingId($user_id);

            //save new transaction
            Transaction::create([
                'user_id'                => auth()->id(),
                'amount'                 => $gateway->getPrice(),        // Price Should Be In Rial Format; Not Toman
                'type'                   => 1,                           // Increasing Credit Type Is 1
                'product_id'             => 0,                           // Increasing Credit Does Not Have Product
                'gateway_transaction_id' => $gateway->transactionId()    // invoiceNumber
            ]);



            return redirect($this->redirectCartPath.'?status=success&receipt=asdasdasd');

        }  catch (\Exception $e) {
            if (!$e instanceof \App\Services\PaymentGateway\Exception\GatewayException)
            {
                Log::channel('payment')->error('user_id: '. \auth()->id() . ' ------- in controller catch ------ '.PHP_EOL. $e->getMessage() );
                return redirect($this->$redirectCartPath.'?status=failed&message=خطا در پرداخت');
            }
            return redirect($this->$redirectCartPath.'?status=failed&message='.$e->getMessage());
        }
    }
}
