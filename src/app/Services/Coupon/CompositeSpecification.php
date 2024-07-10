<?php

namespace App\Services\Coupon;

use App\Services\Coupon\Validation\Contract\Specification;

class CompositeSpecification implements Validation\Contract\Specification
{

    protected array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy($coupon): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($coupon)) {
                return false;
            }
        }

        return true;
    }
}
