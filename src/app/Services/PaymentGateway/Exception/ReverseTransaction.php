<?php

namespace App\Services\PaymentGateway\Exception;

class ReverseTransaction extends GatewayException
{
    protected $message= 'مشکل در برگشت تراکنش';
}
