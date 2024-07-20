<?php

namespace Database\Factories;

use App\Enums\TransactionTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_ids =  User::query()->get()->pluck('id')->toArray();
        return [
            'user_id'             => Arr::random($user_ids),
            'amount'              => rand(1, 9) * 100000 ,
            'transaction_type'    => $this->faker->randomElement(TransactionTypeEnum::cases()),
            'user_description'    => $this->faker->sentence(),
            'system_description'  => $this->faker->sentence(),
        ];
    }
}
