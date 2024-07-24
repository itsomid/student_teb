<?php

namespace App\DTO\StudentCourse;

class StudentClassBlockResponseDTO
{
    private ?string $description;
    private bool $isBlocked;

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;
        return $this;
    }

    public function getIsBlocked(): bool
    {
        return $this->isBlocked;
    }
}
