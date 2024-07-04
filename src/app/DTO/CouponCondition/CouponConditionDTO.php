<?php

namespace App\DTO\CouponCondition;

class CouponConditionDTO
{
    private bool   $for_last_year_students;
    private int    $last_year_minimum_purchase;

    private string $purchases_status;
    private array $purchased_items;

    private int    $cart_items_count;
    private array  $specified_cart_items;

    private string $grade;
    private string $field_of_study;

    /**
     * @param bool $for_last_year_students
     * @return CouponConditionDTO
     */
    public function setForLastYearStudents(bool $for_last_year_students): CouponConditionDTO
    {
        $this->for_last_year_students = $for_last_year_students;
        return $this;
    }

    /**
     * @param int $last_year_minimum_purchase
     * @return CouponConditionDTO
     */
    public function setLastYearMinimumPurchase(int $last_year_minimum_purchase): CouponConditionDTO
    {
        $this->last_year_minimum_purchase = $last_year_minimum_purchase;
        return $this;
    }

    /**
     * @param string $purchases_status
     * @return CouponConditionDTO
     */
    public function setPurchasesStatus(string $purchases_status): CouponConditionDTO
    {
        $this->purchases_status = $purchases_status;
        return $this;
    }

    /**
     * @param array $purchased_items
     * @return CouponConditionDTO
     */
    public function setPurchasedItems(array $purchased_items): CouponConditionDTO
    {
        $this->purchased_items = array_map('intval', array_keys($purchased_items)) ;
        return $this;
    }

    /**
     * @param int $cart_items_count
     * @return CouponConditionDTO
     */
    public function setCartItemsCount(int $cart_items_count): CouponConditionDTO
    {
        $this->cart_items_count = $cart_items_count;
        return $this;
    }

    /**
     * @param array $specified_cart_items
     * @return CouponConditionDTO
     */
    public function setSpecifiedCartItems(array $specified_cart_items): CouponConditionDTO
    {
        $this->specified_cart_items = array_map('intval', array_keys($specified_cart_items));
        return $this;
    }

    /**
     * @param string $grade
     * @return CouponConditionDTO
     */
    public function setGrade(string $grade): CouponConditionDTO
    {
        $this->grade = $grade;
        return $this;
    }


    /**
     * @param string $field_of_study
     * @return CouponConditionDTO
     */
    public function setFieldOfStudy(string $field_of_study): CouponConditionDTO
    {
        $this->field_of_study = $field_of_study;
        return $this;
    }

    public function getObject(): array
    {
        return [
            'for_last_year_students'      => $this->for_last_year_students,
            'last_year_minimum_purchase'  => $this->last_year_minimum_purchase,
            'purchases_status'            => $this->purchases_status,
            'purchased_items'             => $this->purchased_items,
            'cart_items_count'            => $this->cart_items_count,
            'specified_cart_items'        => $this->specified_cart_items,
            'grade'                       => $this->grade,
            'field_of_study'              => $this->field_of_study,
        ];
    }

}
