<?php

namespace App\DTO\StudentCourse;

use App\Enums\ClassStatusEnum;
use Illuminate\Support\Carbon;

class ClassDetailDTO
{
    private string $name;
    private bool $qaStatus;
    private int $classId;
    private int $productId;
    private ?Carbon $holdingDate;
    private bool $activeHomework;
    private bool $forceHomework;
    private bool $foreReport;
    private string $description;
    private int $teacherId;
    private string $teacherImage;
    private ClassStatusEnum $classStatus;
    private string $courseName;

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setQaStatus(bool $qaStatus): self
    {
        $this->qaStatus = $qaStatus;
        return $this;
    }

    public function isQaStatus(): bool
    {
        return $this->qaStatus;
    }

    public function setClassId(int $classId): self
    {
        $this->classId = $classId;
        return $this;
    }

    public function getClassId(): int
    {
        return $this->classId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setIsActiveHomework(bool $activeHomework): self
    {
        $this->activeHomework = $activeHomework;
        return $this;
    }

    public function getIsActiveHomework(): bool
    {
        return $this->activeHomework;
    }

    public function setIsForceHomework(bool $forceHomework): self
    {
        $this->forceHomework = $forceHomework;
        return $this;
    }

    public function getIsForceHomework(): bool
    {
        return $this->forceHomework;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setIsForeReport(bool $foreReport): self
    {
        $this->foreReport = $foreReport;
        return $this;
    }

    public function getIsForeReport(): bool
    {
        return $this->foreReport;
    }

    public function setTeacherId(int $teacherId): self
    {
        $this->teacherId = $teacherId;
        return $this;
    }

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function setTeacherImage(string $teacherImage): self
    {
        $this->teacherImage = $teacherImage;
        return $this;
    }

    public function getTeacherImage(): string
    {
        return $this->teacherImage;
    }

    public function setClassStatus(ClassStatusEnum $classStatus): self
    {
        $this->classStatus = $classStatus;
        return $this;
    }

    public function getClassStatus(): ClassStatusEnum
    {
        return $this->classStatus;
    }

    public function setCourseName(string $courseName): self
    {
        $this->courseName = $courseName;
        return $this;
    }

    public function getCourseName(): string
    {
        return $this->courseName;
    }

    public function setHoldingDate(?Carbon $holdingDate): self
    {
        $this->holdingDate = $holdingDate;
        return $this;
    }

    public function getHoldingDate(): ?Carbon
    {
        return $this->holdingDate;
    }

}
