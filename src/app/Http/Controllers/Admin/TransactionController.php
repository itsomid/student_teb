<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        // Retrieve the transactions along with the associated user, ordered by the latest
        $transactions = Transaction::query()->with('user' , function ( $query ) {
            $query->select( 'id' , 'name');
        })
        ->latest()
        ->get();

        // Return the view with the transactions data
        return view('dashboard.transaction.index')->with(['transactions' => $transactions]);
    }
}
