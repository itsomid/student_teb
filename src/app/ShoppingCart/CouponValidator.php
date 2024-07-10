<?php

namespace App\ShoppingCart;

use App\Models\Coupon;
use App\Models\User;
use App\Services\Coupon\CouponService;

class CouponValidator
{
    public function isCouponValid(int $couponId, int $user, int $product): bool
    {
        return  (new CouponService)->validateCoupon($couponId, $user , $product);
    }
}
