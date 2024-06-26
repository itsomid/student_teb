<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Enums\ProductAccessType;
use App\Events\OrderCreated;
use App\Models\ProductAccess;
use App\Models\User;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Contract\CartItemInterface;

class OrderService
{

    private int $userId;
    public function buy(int $userId): void
    {
        CartAdaptor::init($userId);

        $this->userId = $userId;

        $user = User::find($userId);
        $order = $user->orders()
            ->create([
                'vat_tax' => CartAdaptor::getTotalTax(),
                'total_payable_price' => CartAdaptor::getPayableAmount(),
                'total_discount' => 0,
                'installment_total_amount' => 1,
                'repayment_count' => 1,
                'status' => OrderStatusEnum::PAID
            ]);

        //Loop
        CartAdaptor::getItems()->each(function (CartItemInterface $item) use($order){

            if ($item::IS_PACKAGE){
                $amount = $item->getCalcPrice();
                $sum = 0;
                $item->getModel()->packages->each(function ($pkg) use(&$sum) {
                    $sum += $pkg->getModel()->product->price;
                });

                $item->getModel()->packages->map(function ($course) use($order, $amount, $sum) {
                    $amount_temp = (int) (($course->product->price*$amount)/$sum);

                    $itemModel = $order->items()->create([
                        'product_id' => $course->product_id,
                        'final_price' => $amount_temp,
                        'product_price' => $course->product->original_price,
                        'discount_price' => 0
                    ]);
                    $this->accessProduct($course->product_id, $itemModel->id);

                });
            }

            $itemModel = $order->items()->create([
                'product_id' => $item->product_id,
                'final_price' => $item::IS_PACKAGE ? 0 : $item->getCalcPrice(),
                'product_price' => $item->getModel()->product->original_price,
                'discount_price' => 0
            ]);

            $this->accessProduct($item->product_id, $itemModel->id);
            CartAdaptor::remove($item->product_id);
        });

        OrderCreated::dispatch($order);
    }

    /**
     * @param int $productId
     * @param int $orderItemId
     * @return void
     */
    public function accessProduct(int $productId, int $orderItemId): void
    {
        ProductAccess::query()
            ->create([
                'product_id' => $productId,
                'user_id' => $this->userId,
                'access_reason_type' => ProductAccessType::BOUGHT,
                'order_item_id' => $orderItemId
            ]);
    }
}
