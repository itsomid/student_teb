<?php

namespace App\Console\Commands;

use App\Enums\CategoryKeyEnum;
use App\Enums\CommissionSpecificationTypeEnum;
use App\Models\Commission;
use App\Models\CommissionType;
use App\Models\Order;
use App\Models\Product;
use App\Models\Products;
use Illuminate\Console\Command;
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
    protected $description = 'calculate agent commission';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $commissions = Commission::query()
            ->with('type:id,percentage')
            ->select('support_id', 'type_id')
            ->whereHas('type', fn($q) => $q->where('specification', CommissionSpecificationTypeEnum::NonCapital))
            ->get()
            ->keyBy('support_id');
        $orders = Order::query()
            ->select('id', 'sales_support_id')
            ->whereIn('sales_support_id', $commissions->pluck('support_id'))
            ->where('is_agent_commission_processed', false)
            ->with('items', 'user', 'items.cash_amount', 'items.product', 'items.product.categories')
            ->get();

        foreach ($orders as $order) {
            foreach ($order->items as $orderItem) {
                $commissionPercentage = $commissions[$order->sales_support_id]->type->percentage;
                $isConsulting = !! $orderItem->product->categories->where('key', CategoryKeyEnum::CONSULTING_PLANNING)->count();
                if ($isConsulting) {
                    $commissionPercentage = 0.1;
                }else {
                    $discount = 1 - ($orderItem->final_price_without_vat/$orderItem->product->original_price);
                    if ($discount>0 && $discount<$commissionPercentage){
                        //calculate new commission based on discount
                        $alpha = $orderItem->product->original_price - $orderItem->final_price_without_vat;
                        $com = $commissionPercentage*$orderItem->product->original_price-$alpha;
                        $newCommission = $com/$orderItem->final_price_without_vat;
                        $commissionPercentage = $newCommission;
                    }elseif ($discount>=$commissionPercentage){
                        $commissionPercentage = 0.1;
                    }
                }
                $orderItem->cash_amount()->update([
                    'agent_commission_amount' => (int) ($orderItem->cash_amount->cash_amount * $commissionPercentage)
                ]);
            }
            $order->update([
                'is_agent_commission_processed' => true //Mark as processed
            ]);
        }
    }
}
