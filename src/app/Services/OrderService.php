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
use Exception;
use Illuminate\Database\Eloquent\Model;

class OrderService
{
    private int $userId;
    private array $installments = [];
    private int $giftAmountPerItem = 0;
    public function buy(int $userId) : Order
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
        $this->giftAmountPerItem = $this->calculateItemGiftAmount($user->account->gift_balance, count(CartAdaptor::getItems()));
        $user->account->gift_balance = 0;
        $user->account->cash_balance = 0; // This line might need to be revisited
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
        if($user->account->cash_balance < $order->final_price){
            $user->account->cash_balance = 0;
            $user->account->gift_balance -= $giftAmountUsage = ($order->final_price - $user->account->cash_balance);
            $this->giftAmountPerItem = $this->calculateItemGiftAmount($giftAmountUsage, count(CartAdaptor::getItems()));
        }else{
            $user->account->cash_balance -= $order->final_price;
            $this->giftAmountPerItem = 0; // it's not use gift amount, final_price is enough
        }
        if ($user->account->gift_balance < 0){
            throw new Exception("Student balance can not be negative");
        }
        $user->account->save();

        return $order;
    }

    /**
     * Calculate amount usage from gift amount in every order items
     * @param int $giftAmount
     * @param int $itemSize
     * @return int
     */
    private function calculateItemGiftAmount(int $giftAmount, int $itemSize): int
    {
        if ($giftAmount === 0){
            return 0;
        }
        return (int)($giftAmount / $itemSize);
    }
    private function createOrder(User $user): Model|Order
    {
        return $user->orders()->create([
            'vat_tax' => CartAdaptor::getTotalTax(),
            'total_payable_price' => CartAdaptor::getPayableAmount(),
            'total_discount' => CartAdaptor::getAppliedCouponAmount() ,
            'final_price' =>  CartAdaptor::getFinalPrice() + CartAdaptor::getAppliedCouponAmount(),
            'repayment_count' => CartAdaptor::getInstallmentCount() - 1, // always one of them are paid
            'status' => OrderStatusEnum::PAID,
            'sales_support_id' => $user->sale_support_id
        ]);
    }

    private function processItems(Order $order, callable $callback): void
    {
        CartAdaptor::getItems()->each(function (CartItemInterface $item) use ($order, $callback) {
            $callback($item);
            CartAdaptor::remove($item->product_id);

        });
        OrderCreated::dispatch($order);
    }

    private function processCartItem($order, $item)
    {
        if ($item::IS_PACKAGE) {
            $this->processPackageItem($order, $item);
        } else {
            $this->processRegularItem($order, $item);
        }
    }

    private function processPackageItem(Order $order, CartItemInterface $item): void
    {
        $amount = $item->getCalcPrice();

        $sum = $item->getModel()->packages->sum(function ($pkg) {
            return $pkg->getModel()->product->price;
        });
        $itemModel = $order->items()->create([
            'product_id' => $item->product_id,
            'final_price' => $amount,
            'product_price' => $item->getModel()->product->price,
            'discount_price' => $item->getCouponDiscountAmount(),
            'user_gift_amount' => $this->giftAmountPerItem
        ]);

        if (array_key_exists($item->product_id, $this->installments)) {
            $this->generateInstallments($item->product_id, $itemModel->id);
        }
        // Divides  giftAmountPerItem to package items
        $packageItemGiftAmount = $this->calculateItemGiftAmount($this->giftAmountPerItem, count($item->getModel()->packages));
        $item->getModel()->packages->each(function ($pkg) use ($order, $amount, $sum, $packageItemGiftAmount) {
            $amount_temp = (int)(($pkg->getModel()->product->price * $amount) / $sum);
            $itemModel = $order->items()->create([
                'product_id' => $pkg->product_id,
                'final_price' => $amount_temp,
                'product_price' => $pkg->getModel()->product->original_price,
                'discount_price' => 0,
                'user_gift_amount' => $packageItemGiftAmount
            ]);
            $this->accessProduct($pkg->product_id, $itemModel->id);
        });
    }

    private function processRegularItem(Order $order, CartItemInterface $item): void
    {
        $price = $item->getModel()->product->price;

        $itemModel = $order->items()->create([
            'product_id' => $item->product_id,
            'final_price' => $item->getCalcPrice(),
            'product_price' => $price,
            'discount_price' => $item->getCouponDiscountAmount(),
            'user_gift_amount' => $this->giftAmountPerItem
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
