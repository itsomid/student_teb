<?php

namespace App\Services;

use App\DTO\StudentAccount\ProductAccessResponseDTO;
use App\Enums\ProductAccessType;
use App\Models\Account;
use App\Models\ProductAccess;
use Illuminate\Database\Eloquent\Builder;

class StudentAccountService
{
    public function getBalance(int $userId): int
    {
        return Account::getStudentBalance($userId);
    }

    /**
     * @param int $userId
     * @param bool $excludeFree
     * @return array
     */
    public function getPurchasedProductIds(int $userId, bool $excludeFree = false): array
    {
        $productAccesses = ProductAccess::query()
            ->where('user_id', $userId)
            ->where(fn (Builder $query) =>
                $query->where('effective_from_datetime', '>=', now())
                        ->orWhereNull('effective_from_datetime')
            )
            ->where(fn (Builder $query) =>
            $query->where('effective_to_datetime', '>=', now())
                ->orWhereNull('effective_to_datetime')
            );

        if ($excludeFree) {
            $productAccesses->where('access_reason_type', ProductAccessType::BOUGHT);
        }

        $productAccesses = $productAccesses->get();

        return $productAccesses->map(fn($access) => $access->product_id)->toArray();
    }
}
