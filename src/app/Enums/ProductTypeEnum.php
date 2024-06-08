<?php

namespace App\Enums;

enum ProductTypeEnum: int
{
    case COURSE  = 1;
    case CLASSES = 2;
    case PACKAGE = 3;
    case CUSTOM_PACKAGE = 4;
    case QUIZ = 5;
    case VAT = 6;

    const array TYPE_LABEL = [
        self::COURSE->value => 'دوره کلاس های زنده',
        self::CLASSES->value => 'کلاس زنده',
        self::PACKAGE->value => 'پکیج محصولات',
        self::CUSTOM_PACKAGE->value => 'پیکج های سفارشی',
        self::QUIZ->value => 'آزمون',
        self::VAT->value => 'مالیات',
    ];
}
