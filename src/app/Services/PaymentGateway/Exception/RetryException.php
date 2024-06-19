<?php

namespace App\Services\PaymentGateway\Exception;

class RetryException extends GatewayException
{
    protected $message= 'نتیجه تراکنش قبلا از طرف بانک اعلام گردیده.';
}
