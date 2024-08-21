<?php

namespace App\Enums;

enum InstallmentStatusEnum: string
{
    case Paid = 'paid';
    case Pending = 'pending';

    const array STATUS_LABEL = [
        self::Paid->value    => 'پرداخت شده',
        self::Pending->value => 'درانتظار پرداخت',
    ];

    const array STATUS_COLOR = [
        self::Paid->value    => 'success',
        self::Pending->value => 'warning',
    ];
}
