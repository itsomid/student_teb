<?php

namespace App\Services;

use App\Models\Account;

class StudentAccountService
{
    public function getAccount(int $userId): int
    {
        return Account::getStudentBalance($userId);
    }
}
