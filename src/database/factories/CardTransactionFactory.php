<?php

namespace Database\Factories;

use App\Enums\CardTransactionStatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardTransaction>
 */
class CardTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => User::query()->inRandomOrder()->first()->id,
            'transaction_id' => Transaction::query()->where('transaction_type', TransactionTypeEnum::DEPOSIT)->inRandomOrder()->first()->id,
            'tracking_code' => $this->faker->unique()->numerify('2######'),
            'amount' => $this->faker->numerify('#000000'),
            'status' => $this->faker->randomElement(CardTransactionStatusEnum::cases()),
            'paid_date' => $this->faker->time,
            'filename' => $this->faker->numerify('#############.jpg'),
            'description' => $this->faker->sentence
        ];
    }
}
