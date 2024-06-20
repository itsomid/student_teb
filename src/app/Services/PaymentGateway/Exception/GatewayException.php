<?php

namespace App\Services\PaymentGateway\Exception;

class GatewayException extends \Exception
{
    protected $message = 'خطای سرویس.';
}
