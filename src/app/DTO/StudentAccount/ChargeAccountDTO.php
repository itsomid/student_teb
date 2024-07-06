<?php

namespace App\DTO\StudentAccount;

use App\Enums\DepositTypeEnum;

class ChargeAccountDTO
{
    private int $amount;
    private int $userId;
    private ?string $userDescription;
    private ?int $adminId;
    private DepositTypeEnum $depositType;

    /**
     * @param int $amount
     * @return $this
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

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
     * @param string|null $userDescription
     * @return $this
     */
    public function setUserDescription(?string $userDescription): self
    {
        $this->userDescription = $userDescription ?? null; // Use empty string if null is passed
        return $this;
    }

    /**
     * @return string
     */
    public function getUserDescription(): string
    {
        return $this->userDescription;
    }

    /**
     * @param int|null $adminId
     * @return $this
     */
    public function setAdminId(?int $adminId): self
    {
        $this->adminId = $adminId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAdminId(): ?int
    {
        return $this->adminId;
    }
    /**
     * @return DepositTypeEnum
     */
    public function getDepositType(): DepositTypeEnum
    {
        return $this->depositType;
    }

    /**
     * @param DepositTypeEnum $depositType
     * @return $this
     */
    public function setDepositType(DepositTypeEnum $depositType): self
    {
        $this->depositType = $depositType;
        return $this;
    }

}
