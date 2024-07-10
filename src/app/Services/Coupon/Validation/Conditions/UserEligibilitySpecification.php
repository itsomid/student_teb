<?php

namespace App\Services\Coupon\Validation\Conditions;

class UserEligibilitySpecification implements \App\Services\Coupon\Validation\Contract\Specification
{
    protected int $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function isSatisfiedBy($coupon): bool
    {
        if (empty($coupon->consumer_ids))
            return true;

        return in_array($this->user_id, $coupon->consumer_ids);
    }
}
