<?php

namespace App\Services\PaymentGateway\Exception;

class NotPaidException extends GatewayException
{
    protected $message= 'پرداخت شما انجام نشده است';
}
