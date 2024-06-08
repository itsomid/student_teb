<?php

namespace App\ShoppingCart;

use App\Models\Coupon;
use App\Models\User;

class CouponValidator
{
    public function isCouponValid(int $couponId, User $user, $product): bool
    {
        return Coupon::isCouponValid($couponId, $user, $product);
    }
}
