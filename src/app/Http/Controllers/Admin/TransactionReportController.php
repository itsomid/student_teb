<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class TransactionReportController extends Controller
{
    public function index()
    {
        $time_span       = request()->input('time_span',7);
        $transaction_type= request()->input('type','deposit');
        $deposit_type    = request()->input('deposit_type','');
        $today = Carbon::now();

        // Get transactions for the last 7 days
        $transactions = Transaction::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                'transaction_type',
                DB::raw('SUM(amount) as total_amount')
            )
            ->whereBetween('created_at', [$today->copy()->subDays($time_span), $today])
            ->where('transaction_type', $transaction_type)
            ->when($transaction_type == 'deposit' && $deposit_type, function ($query) use ($deposit_type) {
                $query->whereHas('deposit', function ($query) use ($deposit_type) {
                    $query->where('deposit_type', $deposit_type);
                });
            })
            ->groupBy('date', 'transaction_type')
            ->orderBy('date', 'asc')
            ->get();


        $chartData = [];

        foreach ($transactions as $transaction) {
            $chartData[$transaction->date] = $transaction->total_amount;
        }


        $dates = [];
        for ($i = 0; $i <= $time_span; $i++) {
            $date = $today->copy()->subDays($time_span - $i)->toDateString();
            $dates[] = Jalalian::forge( $date)->format('m/d');
            if (!array_key_exists($date, $chartData)) {
                $chartData[$date] = 0;
            }
        }

        return view('dashboard.transaction.report.index')
            ->with('dates',   array_reverse($dates))
            ->with('chartData',   $chartData);
    }
}
