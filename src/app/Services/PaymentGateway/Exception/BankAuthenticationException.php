<?php

namespace App\Services\PaymentGateway\Exception;

class BankAuthenticationException extends GatewayException
{
    protected $message= 'اتصال به درگاه با خطا مواجه شده است. لطفا با پشتیبانی تماس بگیرید.کد خطا= 104';
}
