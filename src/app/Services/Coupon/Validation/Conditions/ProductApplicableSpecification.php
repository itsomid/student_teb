<?php

namespace App\Services\Coupon\Validation\Conditions;

use App\Models\Product;

class ProductApplicableSpecification implements \App\Services\Coupon\Validation\Contract\Specification
{

    protected int $product_id;

    public function __construct(int $product_id)
    {
        $this->product_id = $product_id;
    }

    public function isSatisfiedBy($coupon): bool
    {
        if (empty($coupon->product_ids))
            return true;

        return in_array($this->product_id, $coupon->product_ids);
    }
}
