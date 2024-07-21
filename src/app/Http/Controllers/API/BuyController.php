<?php

namespace App\Http\Controllers\API;

use App\Enums\TransactionTypeEnum;
use App\Helpers\PaymentGateway\Exception\GatewayException;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\OrderService;
use App\ShoppingCart\CartAdaptor;
use \App\Services\PaymentGateway\Gateway;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
//        $auth->loginUsingId(33);

        CartAdaptor::init($auth->id());

        $payableForBank = CartAdaptor::getPayableAmount() - $auth->user()->balance;

        if ($payableForBank > 0) {

            try {
                $gateway = Gateway::initial();
                $gateway->setCallback('/callback_from_gateway');
                $gateway->price($payableForBank)->ready();
                return $gateway->redirect();
            } catch (Throwable $exception) {
                return view('bank.bank')->with('error_message', $exception->getMessage());
            }

        } else {
            DB::beginTransaction();
            try {

                $order = $this->orderService->buyWithCredit($auth->id());

                DB::commit();
                return redirect($this->redirectCartPath.'?status=success&receipt='.$order->id);

            } catch (Throwable $e) {
                report($e->getMessage());
                DB::rollBack();
                return redirect($this->redirectCartPath.'?status=failed');

//                return response([
//                    'message' => 'مشکلی پیش آمده است لطفا بعدا تلاش کنید' . $e->getMessage()
//                ], Response::HTTP_NOT_FOUND);
            }
        }

    }

}
