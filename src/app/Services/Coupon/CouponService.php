<?php

namespace App\Services\Coupon;

use App\Models\Coupon;
use App\Services\Coupon\Validation\Conditions\CouponExpirySpecification;
use App\Services\Coupon\Validation\Conditions\ProductApplicableSpecification;
use App\Services\Coupon\Validation\Conditions\UserEligibilitySpecification;

class CouponService
{
    public function validateCoupon(int $couponId, int $product_id, int $user_id): bool
    {
        $coupon = Coupon::query()->find($couponId);

        $expirySpec  = new CouponExpirySpecification();
        $productSpec = new ProductApplicableSpecification($product_id);
        $userSpec    = new UserEligibilitySpecification($user_id);

        $compositeSpec = new CompositeSpecification($expirySpec, $productSpec, $userSpec);

        return $compositeSpec->isSatisfiedBy($coupon);
    }
}
