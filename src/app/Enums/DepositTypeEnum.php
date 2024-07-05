<?php

namespace App\Enums;

enum DepositTypeEnum: string
{
    case Admin = 'admin';
    case Gift = 'gift';
    case Debit = 'debit';
    case BUY = 'buy';
}
