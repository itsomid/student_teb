<?php

namespace App\Console\Commands;

use App\Models\InstallmentRepayment;
use App\Models\OrderItem;
use App\ShoppingCart\Installment;
use Illuminate\Console\Command;

class BlockAccessOnOverdueInstallments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:block-access-on-overdue-installments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdue_installments = OrderItem::query()
            ->whereHas('installment_repayment',function($q){
                return $q->where('status', 'pending')->whereDate('expired_at', '<', now());
            })
            ->with('product_access')
            ->get();

        foreach($overdue_installments as $overdue_installment){
            $overdue_installment->product_access()->update([
                'access_blocked_on_overdue_installment' => true
            ]);
        }
    }
}
