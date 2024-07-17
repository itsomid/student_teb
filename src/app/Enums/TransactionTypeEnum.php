<?php

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case BUY = 'buy';
    case DEPOSIT = 'deposit';
    case VAT_TAX = 'vat_tax';
    case DISCOUNT = 'discount';

    const array TYPE_LABEL = [
        self::BUY->value => 'خرید',
        self::DEPOSIT->value => 'واریز',
        self::VAT_TAX->value => 'مالیات',
        self::DISCOUNT->value => 'تخفیف',
    ];

    const array TYPE_COLOR = [
        self::BUY->value      => 'primary',
        self::DEPOSIT->value  => 'success',
        self::VAT_TAX->value  => 'warning',
        self::DISCOUNT->value => 'danger',
    ];
}
