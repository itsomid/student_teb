<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\ShoppingCart\CartAdaptor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class BuyController extends Controller
{

    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function payCart()
    {
        $auth = Auth::guard('student');

        CartAdaptor::init($auth->id());
        $payableForBank = CartAdaptor::getPayableAmount() - $auth->user()->credit;

        if ($payableForBank > 0){
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

        return response([
            'message' => 'در حال اتنقال به درگاه' //TODO
        ]);
    }
}
