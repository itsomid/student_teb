<?php

namespace App\Services\Coupon\Validation\Conditions;

use Carbon\Carbon;

class CouponExpirySpecification implements \App\Services\Coupon\Validation\Contract\Specification
{
    public function isSatisfiedBy($coupon): bool
    {
        return Carbon::parse($coupon->expired_at)->isFuture();
    }
}
