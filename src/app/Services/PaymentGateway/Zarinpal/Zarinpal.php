<?php

namespace App\Services\PaymentGateway\Zarinpal;

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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Zarinpal extends PortAbstract implements PortInterface
{
    public  $authority;
    protected $callbackUrl;
    protected $invoiceMaker=        "https://api.zarinpal.com/pg/v4/payment/request.json";
    protected $redirectPath=        "https://www.zarinpal.com/pg/StartPay/";
    protected $verificationPath=    "https://api.zarinpal.com/pg/v4/payment/verify.json";


    public function set($amount)
    {
        $this->amount = intval($amount);
        return $this;
    }

    public function ready()
    {
        $this->setPortName('ZARINPAL');

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

        $data = [
            "merchant_id" => config('gateway.zarinpal.merchant'),
            "amount" => $this->getPrice(),
            "callback_url" => $this->getCallback(),
            "description" => "خرید تست",
        ];


        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($this->invoiceMaker, $data);

        if ($response->status() != 200)
            throw new BankAuthenticationException();

        $result = json_decode($response->getBody()->getContents());

        $this->gatewayPath= $this->redirectPath.$result->data->authority.'?transaction_id='.$this->trans_id;;
    }

    public function setCallback($url)
    {
        $this->callbackUrl = url('') .$url;
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

        $authority = request()->input('Authority');

        $data = [
            "merchant_id" => config('gateway.zarinpal.merchant'),
            "authority" => $authority,
            "amount" => $this->transaction->price,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->verificationPath, $data);

        $result = json_decode($response->getBody()->getContents(), true);

        if(isset($result['errors']) && isset($result['errors']['code']) && $result['errors']['code'] != 100)
        {
            $this->setDescription('هنگام تایید تراکنش، بانک پاسخ نداد.');
            $this->transactionFailed();
            throw new NotPaidException;
        }


        if($response->status() != 200 || $response->status() != 201)
        {
            $this->setDescription('هنگام تایید تراکنش، بانک پاسخ نداد.');
            $this->transactionFailed();
            throw new BankException();
        }

        $this->refId =  $result->data->ref_id;
        $this->urlid = $authority;

        $this->transactionSetRefId();
        $this->transactionSucceed();

        Log::channel('payment')->info('user_id: '.$user_id. ' invoice accomplishment saved');


        $this->newLog($status_code, 'SUCCEED');

        return $this;
    }
}
