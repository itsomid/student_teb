<?php

namespace App\Legacy\Listeners;

use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\InstallmentRepayment;
use App\Models\Order;
use App\Models\ProductAccess;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Throwable;

class NexusCartSaveReceipt implements LegacyContract
{
    /**
     * 'installment_repayments' => [],
     * 'orders' => [],
     * 'order_items' => [],
     * 'deposits' => [],
     * 'transactions' => []
     */

    public function handle(object $data): void
    {
        try{
            DB::beginTransaction();
            foreach ($data->installment_repayments as $installment){
                InstallmentRepayment::query()->create([
                    'amount' => $installment->amount,
                    'expired_at' => $installment->expired_at,
                    'user_id' => $installment->user_id,
                    'order_item_id' => null,
                    'status' => $installment->status
                ]);
            }

            $order = Order::query()->create([
                'user_id' => $data->orders->user_id,
                'vat_tax' => $data->orders->vat_tax,
                'total_payable_price' => $data->orders->total_payable_price,
                'final_price' => $data->orders->final_price,
                'total_discount' => $data->orders->total_discount,
                'repayment_count' => $data->orders->repayment_count,
                'status' => $data->orders->status
            ]);

            foreach ($data->order_items as $item){
                $itemCreated = $order->items()->create([
                    'product_id' => $item->product_id,
                    'coupon_id' => $item->coupon_id,
                    'final_price' => $item->final_price,
                    'product_price' => $item->product_price,
                    'discount_price' => $item->discount_price
                ]);

                $itemCreated->product_access()->create([
                    'user_id' => $item->user_id,
                    'product_id' => $item->product_id,
                    'effective_from_datetime' => $item->effective_from_datetime,
                    'effective_to_datetime' => $item->effective_to_datetime,
                    'access_reason_type' => $item->access_reason_type,
                ]);
            }
            foreach ($data->transactions as $transaction) {

                Transaction::query()
                    ->create([
                        'user_id' => $transaction->user_id,
                        'amount' => $transaction->amount,
                        'transaction_type' => $transaction->transaction_type,
                        'user_description' => $transaction->user_description,
                        'system_description' => $transaction->system_description,
                    ]);
            }


            DB::commit();
        }catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }

    }
}
