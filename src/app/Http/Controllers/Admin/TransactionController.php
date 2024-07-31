<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $depositAmountSum = Transaction::query()
            ->select('amount')
            ->where('transaction_type','deposit')
            ->whereDate('created_at', $today)
            ->sum('amount');

        $depositCount = Transaction::query()
            ->select('id')
            ->where('transaction_type','deposit')
            ->whereDate('created_at', $today)
            ->count();

        $usersWithGreatestAmountOfTransaction = Transaction::query()
            ->select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->with('user' , function ( $query ) {
                $query->select( 'id' , 'name');
            })
            ->groupBy('user_id')
            ->where('transaction_type','deposit')
            ->whereDate('created_at', $today)
            ->orderByDesc('total_amount')
            ->take(3)
            ->get();


        // Retrieve the transactions along with the associated user, ordered by the latest
        $transactions = Transaction::query()->with('user' , function ( $query ) {
            $query->select( 'id' , 'name');
        })
        ->with('deposit')
        ->filterBy(request()->all())
        ->paginate(100);

        // Return the view with the transactions data
        return view('dashboard.transaction.index')
            ->with(['depositAmountSum' => $depositAmountSum])
            ->with(['depositCount'     => $depositCount])
            ->with(['transactions'     => $transactions])
            ->with(['usersWithGreatestAmountOfTransaction'     => $usersWithGreatestAmountOfTransaction]);
    }
}
