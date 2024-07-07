<?php

namespace App\Services\PaymentGateway\Event;

use App\Models\GatewayTransaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentTransactionSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public GatewayTransaction $gatewayTransaction)
    {
    }
}
