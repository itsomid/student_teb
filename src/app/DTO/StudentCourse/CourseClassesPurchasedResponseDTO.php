<?php

namespace App\DTO\StudentCourse;

class CourseClassesPurchasedResponseDTO
{
    private int $classId;
    private string $name;
    private string $status;
    private bool $isFree;
    private ?string $holdingDate = null;

    public function setClassId(int $classId): self
    {
        $this->classId = $classId;
        return $this;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setIsFree(bool $isFree): self
    {
        $this->isFree = $isFree;
        return $this;
    }

    public function getIsFree(): bool
    {
        return $this->isFree;
    }

    public function setHoldingDate(?string $classHoldingDate): self
    {
        $this->holdingDate = $classHoldingDate;
        return $this;
    }

    public function getHoldingDate(): ?string
    {
        return $this->holdingDate;
    }

}
