<?php

namespace App\Console\Commands;

use App\Enums\CategoryKeyEnum;
use App\Enums\CommissionSpecificationTypeEnum;
use App\Models\Commission;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CalculateAgentCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-agent-commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate agent commission';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $commissions = $this->getCommissions();
            $orders = $this->getRelatedSupportOrders($commissions->pluck('support_id')->toArray());

            foreach ($orders as $order) {
                $this->processOrderItems($order, $commissions);
                $this->markOrderAsProcessed($order);
            }
        });
    }

    /**
     * Retrieve commissions with related types.
     */
    private function getCommissions(): Collection
    {
        return Commission::query()
            ->with('type:id,percentage')
            ->select('support_id', 'type_id')
            ->whereHas('type', fn($q) => $q->where('specification', CommissionSpecificationTypeEnum::NonCapital))
            ->get()
            ->keyBy('support_id');
    }

    /**
     * Retrieve orders that need commission processing.
     */
    private function getRelatedSupportOrders(array $supportIds): Collection
    {
        return Order::query()
            ->select('id', 'sales_support_id')
            ->whereIn('sales_support_id', $supportIds)
            ->where('is_agent_commission_processed', false)
            ->with('items', 'user', 'items.cash_amount', 'items.product', 'items.product.categories')
            ->get();
    }

    /**
     * Process commission for each item in the order.
     */
    private function processOrderItems(Order $order, Collection $commissions): void
    {
        foreach ($order->items as $orderItem) {
            $commissionPercentage = $this->calculateCommissionPercentage($orderItem, $commissions[$order->sales_support_id]->type->percentage);
            $this->updateItemCommission($orderItem, $commissionPercentage);
        }
    }

    /**
     * Calculate the appropriate commission percentage.
     */
    private function calculateCommissionPercentage(OrderItem $orderItem, float $baseCommissionPercentage): float
    {
        $isConsultingProduct = $this->isConsultingProduct($orderItem);

        if ($isConsultingProduct) {
            return 0.1;
        }

        $discount = $this->calculateDiscount($orderItem);
        return $this->adjustCommissionForDiscount($baseCommissionPercentage, $discount, $orderItem);
    }

    /**
     * Check if the product is a consulting product.
     */
    private function isConsultingProduct(OrderItem $orderItem): bool
    {
        return !! $orderItem->product->categories->where('key', CategoryKeyEnum::CONSULTING_PLANNING)->count();
    }

    /**
     * Calculate the discount for the item.
     */
    private function calculateDiscount(OrderItem $orderItem): float
    {
        return 1 - ($orderItem->final_price_without_vat / $orderItem->product->original_price);
    }

    /**
     * Adjust the commission percentage based on the discount.
     */
    private function adjustCommissionForDiscount(float $commissionPercentage, float $discount, OrderItem $orderItem): float
    {
        if ($discount > 0 && $discount < $commissionPercentage) {
            $alpha = $orderItem->product->original_price - $orderItem->final_price_without_vat;
            $com = $commissionPercentage * $orderItem->product->original_price - $alpha;
            return $com / $orderItem->final_price_without_vat;
        } elseif ($discount >= $commissionPercentage) {
            return 0.1;
        }

        return $commissionPercentage;
    }

    /**
     * Update the item's commission amount.
     */
    private function updateItemCommission(OrderItem $orderItem, float $commissionPercentage): void
    {
        $orderItem->cash_amount()->update([
            'agent_commission_amount' => (int)($orderItem->cash_amount->cash_amount * $commissionPercentage)
        ]);
    }

    /**
     * Mark the order as processed.
     */
    private function markOrderAsProcessed(Order $order): void
    {
        $order->update([
            'is_agent_commission_processed' => true
        ]);
    }
}
