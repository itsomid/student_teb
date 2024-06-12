<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case INVALID = 'invalid';
    case PAID = 'paid';
    case INSTALLED = 'installed';
}
