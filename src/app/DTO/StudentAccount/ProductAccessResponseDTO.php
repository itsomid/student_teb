<?php

namespace App\DTO\StudentAccount;

use App\Enums\ProductAccessType;
use Carbon\Carbon;

class ProductAccessResponseDTO
{
    private int $userId;
    private int $productId;
    private ?Carbon $effectiveFromDateTime = null;
    private ?Carbon $effectiveToDateTime = null;
    private ProductAccessType $accessReasonType;

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     * @return $this
     */
    public function setProductId(int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getEffectiveFromDateTime(): ?Carbon
    {
        return $this->effectiveFromDateTime;
    }

    /**
     * @param Carbon|null $effectiveFromDateTime
     * @return $this
     */
    public function setEffectiveFromDateTime(?Carbon $effectiveFromDateTime): self
    {
        $this->effectiveFromDateTime = $effectiveFromDateTime;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getEffectiveToDateTime(): ?Carbon
    {
        return $this->effectiveToDateTime;
    }

    /**
     * @param Carbon|null $effectiveToDateTime
     * @return $this
     */
    public function setEffectiveToDateTime(?Carbon $effectiveToDateTime): self
    {
        $this->effectiveToDateTime = $effectiveToDateTime;
        return $this;
    }

    /**
     * @return ProductAccessType
     */
    public function getAccessReasonType(): ProductAccessType
    {
        return $this->accessReasonType;
    }

    /**
     * @param ProductAccessType $accessReasonType
     * @return $this
     */
    public function setAccessReasonType(ProductAccessType $accessReasonType): self
    {
        $this->accessReasonType = $accessReasonType;
        return $this;
    }
}
