<?php

namespace Database\Factories;

use App\Data\Grades;
use App\DTO\CouponCondition\CouponConditionDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type= Arr::random(['SPECIFIED_STUDENTS_COUPON', 'CONDITIONAL_STUDENT_DISCOUNT']);
        $discount_percentage = Arr::random([true, false]);
        return [
            'type'                => $type,
            'coupon_name'         => Str::random(3),
            'description'         => fake()->sentence,
            'creator_id'          => fake()->numberBetween(1, 11),
            'consumer_ids'        => $type == 'CONDITIONAL_STUDENT_DISCOUNT' ? null : [1, 2, 3, 4],
            'product_ids'         => Arr::random([[2, 3, 4], [], [2, 3]]) ,
            'discount_percentage' => $discount_percentage ? fake()->numberBetween(1, 100) : null,
            'discount_amount'     => $discount_percentage ? null : fake()->numberBetween(1000, 50000),
            'is_one_time'         => fake()->boolean,
            'expired_at'          =>fake()->dateTimeThisMonth(),
            'number_of_use'       => fake()->numberBetween(0, 50),
            'conditions'          =>  $type == 'CONDITIONAL_STUDENT_DISCOUNT' ? $this->getConditions()->getObject() : null
        ];
    }

    private function getConditions(): CouponConditionDTO
    {
        return (new CouponConditionDTO())
            ->setForLastYearStudents(Arr::random([true, false]))
            ->setLastYearMinimumPurchase(rand(1,5))
            ->setPurchasesStatus(Arr::random(["all", "once_or_more", "with_no_purchase"]))
            ->setPurchasedItems(Arr::random([[1,2], [2,3,4] , [] ]))
            ->setCartItemsCount(rand(0,3))
            ->setSpecifiedCartItems(Arr::random([[1,2], [2,3,4] , [] ]))
            ->setGrade(Arr::random([[1,2], [10,11,12] , [] ]))
            ->setFieldOfStudy([[1,2], [3,4] , [] ]);
    }
}
