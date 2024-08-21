<?php

namespace App\Services;

use App\DTO\StudentAccount\ProductAccessResponseDTO;
use App\Enums\ProductAccessType;
use App\Models\Account;
use App\Models\ProductAccess;
use App\Repositories\ProductAccessRepository;
use Illuminate\Database\Eloquent\Builder;

class StudentAccountService
{
    /**
     * Get the balance of a student account by user ID.
     *
     * @param int $userId
     * @return int
     */
    public function getBalance(int $userId): int
    {
        return Account::getStudentBalance($userId);
    }

    /**
     * Get the IDs of products purchased by the user.
     *
     * @param int $userId
     * @param bool $excludeFree
     * @return array
     */
    public function getPurchasedProductIds(int $userId, bool $excludeFree = false): array
    {
        $productAccesses = resolve(ProductAccessRepository::class)
                            ->getProductPurchasedId($userId, $excludeFree);

        return $productAccesses->map(fn($access) => $access->product_id)->toArray();
    }

    /**
     * Get the IDs of child products that the user has access to.
     *
     * @param int $userId
     * @return array
     */
    public function getProductChildrenIdsAccess(int $userId): array
    {
        $productService = resolve(ProductService::class);
        return $productService->getProductTreeLeaves(
            $this->getPurchasedProductIds($userId)
        );
    }

    /**
     * Check if the user has access to a specific product.
     *
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function hasAccessToProduct(int $userId, int $productId): bool
    {
        return in_array($productId, $this->getProductChildrenIdsAccess($userId));
    }
}
