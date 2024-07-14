<?php

namespace App\Services;

use App\Models\Account;

class StudentAccountService
{
    public function getBalance(int $userId): int
    {
        return Account::getStudentBalance($userId);
    }
}
