<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'balance', 'gift_amount', 'withdrawable_amount'
    ];

    /**
     * Deposit real amount, exclude gift amount
     * @param int $userId
     * @param int $amount
     * @return void
     */
    public static function deposit(int $userId, int $amount): void
    {
        $account = static::query()
            ->firstOrCreate(['user_id' => $userId], [
                'balance' => 0,
                'gift_amount' => 0,
                'withdrawable_amount' => 0
            ]);

        $account->balance += $amount;
        $account->withdrawable_amount = $account->balance - $account->gift_amount;
        $account->save();
    }


    /**
     * Deposit real amount, exclude gift amount
     * @param int $userId
     * @param int $amount
     * @return void
     */
    public static function depositGift(int $userId, int $amount): void
    {
        $account = static::query()
            ->firstOrCreate(['user_id' => $userId], [
                'balance' => 0,
                'gift_amount' => 0,
                'withdrawable_amount' => 0
            ]);

        $account->balance += $amount;
        $account->gift_amount = $amount;
        $account->withdrawable_amount = $account->balance - $account->gift_amount;
        $account->save();
    }
}
