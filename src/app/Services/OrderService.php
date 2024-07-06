<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Enums\ProductAccessType;
use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\ProductAccess;
use App\Models\User;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Contract\CartItemInterface;

class OrderService
{
    private int $userId;

    public function buy(int $userId): Order
    {
        CartAdaptor::init($userId);
        $this->userId = $userId;

        $user = User::find($userId);
        $order = $this->createOrder($user);

        $this->processItems($order, function (CartItemInterface $item) use ($order) {
            $this->processCartItem($order, $item);
        });

        $user->account->balance = 0; // This line might need to be revisited
        $user->account->save();

        return $order;
    }

    public function buyWithCredit(int $userId): Order
    {
        CartAdaptor::init($userId);
        $this->userId = $userId;

        $user = User::find($userId);
        $order = $this->createOrder($user);

        $this->processItems($order, function (CartItemInterface $item) use ($order) {
            $this->processCartItem($order, $item);
        });

        $user->account->balance -= $order->total_payable_price;
        $user->account->save();

        return $order;
    }

    private function createOrder(User $user): Order
    {
        return $user->orders()->create([
            'vat_tax' => CartAdaptor::getTotalTax(),
            'total_payable_price' => CartAdaptor::getPayableAmount(),
            'total_discount' => 0,
            'installment_total_amount' => 1,
            'repayment_count' => 1,
            'status' => OrderStatusEnum::PAID
        ]);
    }

    private function processItems(Order $order, callable $callback): void
    {
        CartAdaptor::getItems()->each(function (CartItemInterface $item) use ($order, $callback) {
            $callback($item);
            CartAdaptor::remove($item->product_id);
            OrderCreated::dispatch($order);
        });
    }

    private function processCartItem($order, $item)
    {
        if ($item::IS_PACKAGE) {
            $this->processPackageItem($order, $item);
        } else {
            $this->processRegularItem($order, $item);
        }
    }

    private function processPackageItem($order, $item): void
    {
        $amount = $item->getCalcPrice();
        $sum = $item->getModel()->packages->sum(function ($pkg) {
            return $pkg->getModel()->product->price;
        });

        $item->getModel()->packages->each(function ($pkg) use ($order, $amount, $sum) {
            $amount_temp = (int)(($pkg->getModel()->product->price * $amount) / $sum);
            $itemModel = $order->items()->create([
                'product_id' => $pkg->product_id,
                'final_price' => $amount_temp,
                'product_price' => $pkg->getModel()->product->original_price,
                'discount_price' => 0
            ]);
            $this->accessProduct($pkg->product_id, $itemModel->id);
        });
    }

    private function processRegularItem($order, $item): void
    {
        $itemModel = $order->items()->create([
            'product_id' => $item->product_id,
            'final_price' => $item->getCalcPrice(),
            'product_price' => $item->getModel()->product->original_price,
            'discount_price' => 0
        ]);
        $this->accessProduct($item->product_id, $itemModel->id);
    }

    private function accessProduct(int $productId, int $orderItemId): void
    {
        ProductAccess::query()->create([
            'product_id' => $productId,
            'user_id' => $this->userId,
            'access_reason_type' => ProductAccessType::BOUGHT,
            'order_item_id' => $orderItemId
        ]);
    }

}
