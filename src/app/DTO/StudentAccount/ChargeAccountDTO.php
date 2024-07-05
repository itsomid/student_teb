<?php

namespace App\DTO\StudentAccount;

class ChargeAccountDTO
{
    private int $amount;
    private int $userId;
    private string $userDescription;
    private int $adminId;
    private bool $isGift;

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
     * @param string $userDescription
     * @return $this
     */
    public function setUserDescription(?string $userDescription): self
    {
        $this->userDescription = $userDescription ?? ''; // Use empty string if null is passed
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
     * @param int $adminId
     * @return $this
     */
    public function setAdminId(int $adminId): self
    {
        $this->adminId = $adminId;
        return $this;
    }

    /**
     * @return int
     */
    public function getAdminId(): int
    {
        return $this->adminId;
    }

    /**
     * @param bool $isGift
     * @return $this
     */
    public function setIsGift(bool $isGift): self
    {
        $this->isGift = $isGift;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsGift(): bool
    {
        return $this->isGift;
    }

}
