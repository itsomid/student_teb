<?php

namespace App\Legacy\Listeners;

use App\Enums\DepositTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\ProductAccessType;
use App\Enums\TransactionTypeEnum;
use App\Events\OrderCreated;
use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\Account;
use App\Models\Admin;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ProductAccess;
use App\Models\Transaction;
use App\Models\User;

class NexusSaveTransaction implements LegacyContract
{

    /**
     * @param object $data
     * 'type' => 2,
     * 'user_id' => 2,
     * 'product_id' => 2,
     * 'amount' => 1000,
     * 'cash_amount' => 100,
     * 'namayande_commission' => 0,
     * 'description' => test,
     * 'coupon_id' => 5,
     * 'expired_at' => 2022-01-01,
     * 'sales_support' => 2,
     * 'is_virtual' => 0,
     * 'is_kart_be_kart' => 1,
     * 'end_subscription_at' => 2024-02-05,
     * @return void
     */
    public function handle(object $data): void
    {
        $user = User::query()->where('mobile', $data->user_mobile)->first();
        if(is_null($user)){
            echo 'omad inja'.PHP_EOL;
            return;
        }

        // Buy Product
        if($data->type === 0 && $data->description !== 'vat_transaction'){
            $this->syncBuyProduct($data, $user);
        // Increase Credit
        }elseif($data->type === 1 && ! $data->is_kart_be_kart && is_null($data->expired_at)){
            $this->syncIncreaseCredit($data, $user);
        }
    }

    /**
     * @param object $data
     * @return void
     */
    public function syncIncreaseCredit(object $data, User $user): void
    {
        if ($data->is_virtual) {
            $depositType = DepositTypeEnum::Gift;
        } else {
            $depositType = DepositTypeEnum::BUY;
        }

        $transaction = Transaction::query()
            ->where('user_id', $user->id)
            ->where('amount', $data->amount)
            ->where('created_at', $data->created_at)
            ->first();

        $transactionData = [
            'amount' => $data->amount,
            'user_id' => $user->id,
            'user_description' => $data->description,
            'transaction_type' => TransactionTypeEnum::DEPOSIT,
            'created_at' => $data->created_at
        ];

        if (is_null($transaction)) {
            $transaction = Transaction::query()->create($transactionData);
            $transaction->deposit()->create([
                'deposit_type' => $depositType,
                'user_id' => $user->id,
            ]);
            Account::deposit($user->id, $data->amount);

        } else {
            $transaction->update($transactionData);
        }
    }

    /**
     * @param object $data
     * @return void
     */
    public function syncBuyProduct(object $data, User $user): void
    {
        $salesSupport = Admin::query()->where('mobile', $data->sales_support_mobile)->first();
        $coupon = Coupon::query()->where('coupon_name', $data->coupon_name)->first();

        $productAlreadyExists = ProductAccess::query()
            ->where('product_id', $data->product_id)
            ->where('user_id', $user->id)
//            ->when(!empty($data->end_subscription_at), function($q) use($data){
//                echo 'omad|'.$data->end_subscription_at;
//                $q->where('effective_to_datetime', $data->end_subscription_at);
//            })
            ->exists();
        //Already synced
        if($productAlreadyExists){
            return;
        }

        $order = Order::query()->create([
            'user_id' => $user->id,
            'sales_support_id' => $salesSupport->id,
            'vat_tax' => $data->vat_tax,
            'total_payable_price' => $data->amount,
            'final_price' => $data->amount,
            'total_discount' => $data->total_discount,
            'repayment_count' => 0,
            'status' => OrderStatusEnum::PAID,
        ]);
        $orderItem = $order->items()->create([
            'product_id' => $data->product_id,
            'coupon_id' => $coupon->id ?? null,
            'final_price' => $data->amount,
            'final_price_without_vat' => $data->amount - $data->vat_tax,
            'product_price' => $data->product_price,
            'discount_price' => $data->product_price - $data->total_discount,
            'user_girt_amount' => $data->virtual_credit,
        ]);
        $orderItem->product_access()->create([
            'user_id' => $user->id,
            'product_id' => $data->product_id,
            'effective_to_datetime' => $data->end_subscription_at ?: null,
            'access_reason_type' => $data->amount > 0 ? ProductAccessType::BOUGHT : ProductAccessType::FREE
        ]);
        OrderCreated::dispatch($order);
    }
}
