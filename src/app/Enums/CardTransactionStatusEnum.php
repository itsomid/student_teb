<?php

namespace App\Enums;

enum CardTransactionStatusEnum: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case ManagementReview = 'management-review';
}
