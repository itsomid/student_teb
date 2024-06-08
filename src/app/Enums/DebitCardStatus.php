<?php

namespace App\Enums;

enum DebitCardStatus: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case NOT_APPROVED = 3;
    case ADMIN_PROCESSING = 4;
}
