<?php

return [
    'gateway_driver' => env('PAYMENT_GATEWAY', 'zarinpal'),
    'zarinpal' => [
        'merchant' => env('ZARINPAL_MERCHENT', "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx")
    ],
];
