<?php
namespace App\Services\PaymentGateway\Passargad;

use App\Services\PaymentGateway\Exception\BankAuthenticationException;
use App\Services\PaymentGateway\Exception\BankException;
use App\Services\PaymentGateway\Exception\NotFoundTransactionException;
use App\Services\PaymentGateway\Exception\NotPaidException;
use App\Services\PaymentGateway\Exception\RetryException;
use App\Services\PaymentGateway\Exception\ReverseTransaction;
use App\Services\PaymentGateway\PortAbstract;
use App\Services\PaymentGateway\PortInterface;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Passargad extends PortAbstract implements PortInterface
{
    protected $tokenSupplier=       "https://pep.shaparak.ir/pepg/token/getToken";
    protected $invoiceMaker=        "https://pep.shaparak.ir/pepg/api/payment/purchase";
    protected $verificationPath=    "https://pep.shaparak.ir/pepg/api/payment/verify-transactions";
    protected $paymentInquiry=      "https://pep.shaparak.ir/pepg/api/payment/payment-inquiry";
    protected $reverseTransaction=  "https://pep.shaparak.ir/pepg/api/payment/reverse-transactions";
    protected $gatewayPath;

    public function set($amount)
    {
        $this->amount = intval($amount);
        return $this;
    }

    public function ready()
    {
        $this->setPortName('PASARGAD');

        $this->sendPayRequest();
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    protected function sendPayRequest()
    {
        $this->user(auth()->id());
        $this->trans_id = $this->newTransaction();

        $token= $this->getToken();

        $this->client = new \GuzzleHttp\Client();
        $body = [
            "invoice"        => $this->trans_id,
            "invoiceDate"    => (string) \Carbon\Carbon::now(),
            "amount"         => $this->getPrice(),
            "callbackApi"    => $this->getCallback(),
            "serviceCode"    => 8,
            "terminalNumber" => config('classino.gateway_number'),
        ];

        try {
            $response = $this->client->request('POST', $this->invoiceMaker, [
                'headers' => [
                    'Authorization'  => 'Bearer '.$token,
                ],
                'json' => $body
        ]);
        } catch (ClientException $exception){
            throw $exception->getCode() == 401
                ? new BankAuthenticationException
                : new BankException;
        }

        if ($response->getStatusCode() != 200) {
            $this->transactionFailed();
            throw new BankException;
        };

        $response= json_decode($response->getBody());

        if ($response->resultMsg != "Successful" && $response->resultCode !=0) {
            $this->transactionFailed();
            throw new BankException;
        }

        $this->gatewayPath= $response->data->url;
        cache()->set('invoice_id_'. $this->trans_id, $response->data->urlId, 900);
    }

    public function setCallback($url)
    {
        $this->callbackUrl =$url;
        return $this;
    }

    public function getCallback()
    {
        return $this->callbackUrl.'?transaction_id='.$this->trans_id;
    }

    public function redirect()
    {
        return redirect()->to($this->gatewayPath);
    }

    public function verify($transaction)
    {
        parent::verify($transaction);

        $user_id= $this->transaction->user_id;

        Log::channel('payment')->info('user_id: '.$user_id. ' comes in verify method.' );

        if (!cache()->has('invoice_id_'. request()->input('invoiceId'))){
            $this->newLog(404, 'تراکنش با شناسه ی '. request()->input('invoiceId').' وارد شده منقضی شده است' );
            $this->setDescription('تراکنش با شناسه ی '. request()->input('invoiceId').' وارد شده منقضی شده است' );
            $this->transactionFailed();
            throw new NotFoundTransactionException;
        }


        if (  is_null(request()->input('invoiceId')) or is_null(cache()->get('invoice_id_'. request()->input('invoiceId')))){
            $this->newLog(404, 'پرداخت انجام نشد. درصورت کسر وجه، طی 48 ساعت آینده، مبلغ کسر شده به حساب شما بازگشت داده می شود.' );
            $this->setDescription('پرداخت انجام نشد. درصورت کسر وجه، طی 48 ساعت آینده، مبلغ کسر شده به حساب شما بازگشت داده می شود.');
            $this->transactionFailed();
            throw new NotFoundTransactionException;
        }


        $urlid= cache()->get('invoice_id_'. request()->input('invoiceId'));

        $body = [
            "invoice" => request()->input('invoiceId') ,
            "urlId"   => $urlid ,
        ];


        $token= $this->getToken();


        $this->client = new \GuzzleHttp\Client();

        try {
            $response = $this->client->request('POST', $this->verificationPath, [
                'headers' => [
                    'Authorization'  => 'Bearer '.$token,
                ],
                'json' => $body
            ]);
        }catch (\Exception $exception){
            Log::channel('payment')->error('user_id: '.$user_id. ' invoice verification '. $exception->getMessage() );
            $this->setDescription('هنگام تایید تراکنش، بانک پاسخ نداد.');
            $this->transactionFailed();
            throw new BankException;
        }



        $status_code= $response->getStatusCode();

        if ($status_code != 200) {
            $this->newLog($status_code, " عدم دریافت پاسخ صحیح از بانک شماره ی ارور: " . $status_code );
            $this->setDescription(" عدم دریافت پاسخ صحیح از بانک شماره ی ارور: " . $status_code);
            $this->transactionFailed();
            throw new BankException;
        }




        $response = json_decode($response->getBody());



        if ($response->resultCode != 0){
            $this->newLog($status_code, " فاکتور پرداخت نشده است(احتمالا کلیک بر روی دکمه ی انصراف)" );
            $this->setDescription(" فاکتور پرداخت نشده است(احتمالا کلیک بر روی دکمه ی انصراف)");
            $this->transactionFailed();
            throw new NotPaidException;
        }



        //استعلام پرداخت
        try {
            $body=[
                'invoiceId'=>  $transaction->id
            ];
            $response = $this->client->request('POST', $this->paymentInquiry, [
                'headers' => [
                    'Authorization'  => 'Bearer '.$token,
                ],
                'json' => $body
            ]);
        }catch (\Exception $exception){
            Log::channel('payment')->error('user_id: '.$user_id. ' paymentInquiry '. $exception->getMessage() );
            $this->setDescription('هنگام استعلام تراکنش، بانک پاسخ نداد.');
            $this->transactionFailed();
            throw new BankException;
        }


        $response = json_decode($response->getBody());


        if ($response->resultCode != 0 || $response->data->amount != Str::before($transaction->price,'.')){
            $this->newLog($status_code, "فاکتور پرداخت نشده است(احتمال مغایرت قیمت یا کلیک بر روی دکمه ی انصراف)" );
            $this->setDescription(" فاکتور پرداخت نشده است(احتمال مغایرت قیمت یا کلیک بر روی دکمه ی انصراف)");
            $this->transactionFailed();
            throw new RetryException;
        }




        $this->cardNumber = $response->data->cardNumber;
        $this->refId =  $response->data->referenceNumber;
        $this->trackingCode = $response->data->trackId;
        $this->urlid = $urlid;

        $this->transactionSetRefId();
        $this->transactionSucceed();

        Log::channel('payment')->info('user_id: '.$user_id. ' invoice accomplishment saved');

        cache()->delete('invoice_id_'. request()->input('invoiceId'));

        $this->newLog($status_code, 'SUCCEED');

        return $this;
    }

    private function getToken() : string
    {
        $this->client = new \GuzzleHttp\Client();

        $body = [
            "username" => config('classino.gateway_username'),
            "password" => config('classino.gateway_password'),
        ];

        try {
            $response = $this->client->request('POST', $this->tokenSupplier, [
                'json' => $body
            ]);
        }catch (ClientException $exception){
            throw $exception->getCode() == 401
                ? new BankAuthenticationException
                : new BankException;
        }

        $response= json_decode($response->getBody());
        return $response->token;
    }

    public function reverse($urlId): bool
    {
        $token= $this->getToken();
        try {
            $body = [
                "invoice" => request()->input('invoiceId') ,
                "urlId"   => $urlId ,
            ];

            $response = $this->client->post($this->reverseTransaction, [
                'headers' => [
                    'Authorization'  => 'Bearer '.$token,
                ],
                'json' => $body
            ]);
        }catch (ClientException $exception){
            $this->newLog($exception->getCode(), "مشکل در برگشت تراکنش" );
            throw $exception->getCode() == 401
                ? new BankAuthenticationException
                : new BankException;
        }
        if ($response->getStatusCode() != 200) {
            $this->newLog($response->getStatusCode(), "مشکل در برگشت تراکنش" );
            throw new BankException;
        };

        $responseDecode= json_decode($response->getBody());
        if ($responseDecode->resultCode != 0 || $responseDecode->resultMsg !== 'Successful'){
            $this->newLog($response->getStatusCode(), "مشکل در برگشت تراکنش" );
            throw new ReverseTransaction;
        }
        $this->transactionReversed();
        return true;
    }

    protected function transactionReversed()
    {
        return $this->getTable()->whereId($this->transactionId)->update([
            'status' => 'REVERSED',
            'updated_at' => Carbon::now(),
        ]);
    }
}
