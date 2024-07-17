<?php

namespace App\Services;

use App\Enums\InstallmentStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\ProductAccessType;
use App\Events\OrderCreated;
use App\Models\InstallmentRepayment;
use App\Models\Order;
use App\Models\ProductAccess;
use App\Models\User;
use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Contract\CartItemInterface;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    private int $userId;
    private array $installments = [];

    public function buy(int $userId): Order
    {
        CartAdaptor::init($userId);
        $this->userId = $userId;

        $user = User::find($userId);
        $order = $this->createOrder($user);
        if (CartAdaptor::isInstallment()) {
            $this->installments = CartAdaptor::getInstallments();
        }

        $this->processItems($order, function (CartItemInterface $item) use ($order) {
            $this->processCartItem($order, $item);
        });

        $user->account->balance = 0;
        $user->account->withdrawal_amount = 0;
        $user->account->save();

        return $order;
    }

    public function buyWithCredit(int $userId): Order
    {
        CartAdaptor::init($userId);
        $this->userId = $userId;

        $user = User::find($userId);
        $order = $this->createOrder($user);
        if (CartAdaptor::isInstallment()) {
            $this->installments = CartAdaptor::getInstallments();
        }

        $this->processItems($order, function (CartItemInterface $item) use ($order) {
            $this->processCartItem($order, $item);
        });

        $user->account->balance -= $order->total_payable_price;
        $user->account->withdrawal_amount -= $order->total_payable_price;
        $user->account->save();

        return $order;
    }

    private function createOrder(User $user): Model|Order
    {
        return $user->orders()->create([
            'vat_tax' => CartAdaptor::getTotalTax(),
            'total_payable_price' => CartAdaptor::getPayableAmount(),
            'total_discount' => 0,
            'final_price' =>  CartAdaptor::getFinalPrice(),
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

        $itemModel = $order->items()->create([
            'product_id' => $item->product_id,
            'final_price' => $amount,
            'product_price' => $amount->getModel()->product->original_price,
            'discount_price' => 0
        ]);

        if (array_key_exists($item->product_id, $this->installments)) {
            $this->generateInstallments($item->product_id, $itemModel->id);
        }

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
        $price = $item->getModel()->product->original_price;
        $itemModel = $order->items()->create([
            'product_id' => $item->product_id,
            'final_price' => $item->getCalcPrice(),
            'product_price' => $price,
            'discount_price' => 0
        ]);

        if (array_key_exists($item->product_id, $this->installments)) {
            $this->generateInstallments($item->product_id, $itemModel->id);
        }
        $this->accessProduct($item->product_id, $itemModel->id, $price === 0);
    }

    private function accessProduct(int $productId, int $orderItemId, bool $isFree = false): void
    {
        ProductAccess::query()->create([
            'product_id' => $productId,
            'user_id' => $this->userId,
            'access_reason_type' => $isFree ? ProductAccessType::FREE : ProductAccessType::BOUGHT,
            'order_item_id' => $orderItemId
        ]);
    }

    /**
     * @param int $productId
     * @param int $orderItemId
     * @return void
     */
    public function generateInstallments(int $productId, int $orderItemId): void
    {
        foreach ($this->installments[$productId] as $index => $installment) {
            InstallmentRepayment::query()->create([
                'amount' => $installment['amount'],
                'expired_at' => $installment['date'],
                'user_id' => $this->userId,
                'order_item_id' => $orderItemId,
                'status' => $index === 0 ? InstallmentStatusEnum::Paid : InstallmentStatusEnum::Pending
            ]);
        }
    }

}
