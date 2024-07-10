<?php

namespace App\Services\Coupon\Validation\Contract;

interface Specification
{
    public function isSatisfiedBy($coupon): bool;
}
