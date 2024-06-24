<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\PaymentGateway\Exception\InvalidRequestException;
use App\Services\PaymentGateway\Exception\NotFoundTransactionException;
use App\Services\PaymentGateway\Exception\RetryException;
use App\Services\PaymentGateway\Gateway;
use App\ShoppingCart\CartAdaptor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class BuyController extends Controller
{
    private string $redirectCartPath;


    public function __construct(private readonly OrderService $orderService)
    {
        $this->redirectCartPath = config('gateway.redirect_cart_path');
    }

    /**
     * @return Application|ResponseFactory|Response|View|RedirectResponse
     */
    public function payCart(): Application|ResponseFactory|Response|View|RedirectResponse
    {
        $auth = Auth::guard('student');
        $auth->loginUsingId(1);

        CartAdaptor::init($auth->id());

        if (! CartAdaptor::getItems()->count()){
            return response(['message' => 'سبد خرید شما خالی می باشد!'], Response::HTTP_NOT_ACCEPTABLE);
        }
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
        }else {
            try {
                $gateway= Gateway::initial();
                $gateway->setCallback(route('bank.cart.callback'));
                $gateway->price($payableForBank)->ready();
                return $gateway->redirect();
            }catch (Throwable $exception){
                return  view('bank.bank')->with('error_message' , $exception->getMessage());
            }
        }
    }

    /**
     * @return Application|ResponseFactory|Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Throwable
     */
    public function cartCallback(): Application|ResponseFactory|Response
    {
        throw_if(!request()->has('transaction_id'), InvalidRequestException::class);

        $transaction = DB::table('gateway_transactions')->where('id', request()->get('transaction_id'))->first();
        throw_if(!$transaction, NotFoundTransactionException::class);
        throw_if(in_array($transaction->status, ['SUCCEED', 'FAILED']), RetryException::class);

        try {
            $gateway = Gateway::initial();
            $gateway->verify($transaction);

            DB::beginTransaction();
            try{

                $orderService = resolve(OrderService::class);
                $orderService->buy($transaction->user_id);
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
    }
}
