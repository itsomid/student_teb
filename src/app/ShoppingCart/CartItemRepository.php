<?php

namespace App\ShoppingCart;
use App\Enums\ProductTypeEnum;
use App\Models\CartItem as CartItemModel;
use Illuminate\Support\Collection;

class CartItemRepository
{
    public function findByUserId(int $userId): Collection
    {
        return CartItemModel::query()
            ->with('product', 'coupon:id,coupon,discount_amount,discount_percentage')
            ->where('user_id', $userId)
            ->get()
            ->map(function($item) {
                if ($item->product_type_id === ProductTypeEnum::COURSE) {
                    $model = resolve(CourseItem::class, [
                        'product_id'=> $item->product_id,
                        'coupon_id'=> $item->coupon_id,
                        'user_id'=> $item->user_id,
                        'is_installment'=> $item->is_installment
                    ]);
                }elseif($item->product_type_id === ProductTypeEnum::CUSTOM_PACKAGE) {
                    $model = resolve(PackageItem::class, [
                        'product_id'=> $item->product_id,
                        'coupon_id'=> $item->coupon_id,
                        'user_id'=> $item->user_id,
                        'is_installment'=> $item->is_installment,
                        'packageItems' => $item->packages->pluck('product_id')->toArray()
                    ]);
                }

                $model->addModel($item);
                return $model;
            });
    }

    public function updateInstallmentByUserId(int $userId, bool $isInstallment): void
    {
        CartItemModel::query()->where('user_id', $userId)->update([
            'is_installment' => $isInstallment
        ]);
    }
}
