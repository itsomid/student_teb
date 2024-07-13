<?php

namespace App\ShoppingCart;

use App\Services\Coupon\CouponService;

class CouponValidator
{
    public function isCouponValid(string $couponCode, int $product, int $user): bool
    {
        return  (new CouponService)->validateCoupon($couponCode, $product, $user);
    }
}
