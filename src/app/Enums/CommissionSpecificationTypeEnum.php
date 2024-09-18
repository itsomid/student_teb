<?php

namespace App\Enums;

enum CommissionSpecificationTypeEnum: string
{
    case ELEMENTARY = 'ELEMENTARY';
    case NonCapital = 'NonCapital';
    case ALL = 'ALL';
}
