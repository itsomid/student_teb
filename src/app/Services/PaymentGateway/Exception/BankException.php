<?php

namespace App\Services\PaymentGateway\Exception;

class BankException extends GatewayException
{
    protected $message= 'خطای اتصال به بانک';
}
