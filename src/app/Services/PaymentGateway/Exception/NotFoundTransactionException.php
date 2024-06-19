<?php

namespace App\Services\PaymentGateway\Exception;

class NotFoundTransactionException extends GatewayException
{
    protected $message= 'چنین پرداختی موجود نمی باشد.';
}
