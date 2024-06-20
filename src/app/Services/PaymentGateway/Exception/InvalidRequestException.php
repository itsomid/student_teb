<?php

namespace App\Services\PaymentGateway\Exception;

class InvalidRequestException extends GatewayException
{
    protected $message='اطلاعات بازگشتی از بانک صحیح نمی باشد.';
}
