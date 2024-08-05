<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
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
        if(request()->input('from_date') xor request()->input('to_date'))
        {
            return redirect()->route('admin.transaction.report.index')->withErrors(['from_date'=>'یکی از تاریخ ها نمیتواند خالی باشد']);
        }


        $transaction_type= request()->input('type','deposit');
        $deposit_type    = request()->input('deposit_type','');
        $from_date       = request()->input('from_date','');
        $to_date         = request()->input('to_date','');
        $today           = Carbon::now();

        // Get transactions for chart
        $transactions = Transaction::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                'transaction_type',
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('transaction_type', $transaction_type)
            ->when($transaction_type == 'deposit' && $deposit_type, function ($query) use ($deposit_type) {
                $query->whereHas('deposit', function ($query) use ($deposit_type) {
                    $query->where('deposit_type', $deposit_type);
                });
            })
            ->when($from_date, function ($query) use ($from_date) {
                $query->where('created_at', '>=', DateFormatter::format($from_date));
            })
            ->when($to_date, function ($query) use ($to_date) {
                $query->where('created_at', '<=', DateFormatter::format($to_date));
            })
            ->when(!$from_date && !$to_date, function ($query) use ($today) {
                $query->whereBetween('created_at', [$today->copy()->subDays(7), $today]);
            })
            ->groupBy('date', 'transaction_type')
            ->orderBy('date', 'asc')
            ->get();


        $chartData = [];

        foreach ($transactions as $transaction) {
            $chartData[$transaction->date] = $transaction->total_amount;
        }


        $time_span=  ($from_date || $to_date)
            ? (int) Carbon::parse($from_date)->diffInDays($to_date) + 1
            : 7;


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
