<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'cash_balance', 'gift_balance'
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
                'cash_balance' => 0,
                'gift_balance' => 0,
            ]);

        $account->cash_balance += $amount;
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
                'cash_balance' => 0,
                'gift_balance' => 0,
            ]);

        $account->gift_balance = $amount;
        $account->save();
    }

    /**
     * @param int $userId
     * @return int
     */
    public static function getStudentBalance(int $userId): int
    {

        $account = Account::firstOrCreate(
            ['user_id' => $userId],
            ['cash_balance' => 0]
        );

        return $account->cash_balance + $account->gift_balance;
    }

    /** Calculate amount payable price
     * @return int
     */
    public function getBalanceAttribute(): int
    {
        return $this->cash_balance + $this->gift_balance;
    }
}
