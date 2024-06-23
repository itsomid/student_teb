<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case BUY = 'buy';
    case DEPOSIT = 'deposit';
    case VAT_TAX = 'vat_tax';
    case DISCOUNT = 'discount';
}
