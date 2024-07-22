<?php

namespace App\DTO\StudentCourse;

use App\Enums\ProductTypeEnum;

class CoursePurchasedResponseDTO
{
    private int $courseId;
    private int $productId;
    private string $name;
    private string $teacherName;
    private string $image;
    private  ProductTypeEnum $productTypeId;
    private ?int $holdingDays1;
    private ?int $holdingDays2;
    private ?int $holdingDays3;
    private ?array $holdingHours1;
    private ?array $holdingHours2;
    private ?array $holdingHours3;
    private $courses;

    /**
     * @param int $courseId
     * @return $this
     */
    public function setCourseId(int $courseId): self
    {
        $this->courseId = $courseId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->courseId;
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
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setTeacherName(string $teacherName): self
    {
        $this->teacherName = $teacherName;
        return $this;
    }


    public function getTeacherName() : string
    {
        return $this->teacherName;
    }

    public function setProductTypeId(ProductTypeEnum $productTypeId): self
    {
        $this->productTypeId = $productTypeId;
        return $this;
    }


    public function getProductTypeId(): ProductTypeEnum
    {
        return $this->productTypeId;
    }
    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param int|null $holdingDays1
     * @return $this
     */
    public function setHoldingDays1(?int $holdingDays1): self
    {
        $this->holdingDays1 = $holdingDays1;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHoldingDays1(): ?int
    {
        return $this->holdingDays1;
    }

    /**
     * @param int|null $holdingDays2
     * @return $this
     */
    public function setHoldingDays2(?int $holdingDays2): self
    {
        $this->holdingDays2 = $holdingDays2;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHoldingDays2(): ?int
    {
        return $this->holdingDays2;
    }

    /**
     * @param int|null $holdingDays3
     * @return $this
     */
    public function setHoldingDays3(?int $holdingDays3): self
    {
        $this->holdingDays3 = $holdingDays3;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getHoldingDays3(): ?int
    {
        return $this->holdingDays3;
    }

    /**
     * @param array|null $holdingHours1
     * @return $this
     */
    public function setHoldingHours1(?array $holdingHours1): self
    {
        $this->holdingHours1 = $holdingHours1;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHoldingHours1(): ?array
    {
        return $this->holdingHours1;
    }

    /**
     * @param array|null $holdingHours2
     * @return $this
     */
    public function setHoldingHours2(?array $holdingHours2): self
    {
        $this->holdingHours2 = $holdingHours2;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHoldingHours2(): ?array
    {
        return $this->holdingHours2;
    }

    /**
     * @param array|null $holdingHours3
     * @return $this
     */
    public function setHoldingHours3(?array $holdingHours3): self
    {
        $this->holdingHours3 = $holdingHours3;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getHoldingHours3(): ?array
    {
        return $this->holdingHours3;
    }

    public function setCoursesCategory($courses): self
    {
        $this->courses = $courses;
        return $this;
    }

    public function getCoursesCategory()
    {
        return $this->courses;
    }
}
