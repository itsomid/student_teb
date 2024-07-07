<?php

namespace App\Enums;

enum InstallmentStatusEnum: string
{
    case Paid = 'paid';
    case Pending = 'pending';
}
