<?php

namespace App\Services\PaymentGateway;

use App\Services\PaymentGateway\Passargad\Passargad;
use App\Services\PaymentGateway\Zarinpal\Zarinpal;

class Gateway
{
    public static function initial() : PortInterface
    {
        if(config('gateway.gateway_driver') == 'zarinpal')
            return new Zarinpal();

        return new Passargad();
    }
    public static function initialPassargad() : PortInterface
    {
        return new Passargad();
    }

    public static function initialZarinpal() : PortInterface
    {
        return new Zarinpal();
    }
}
