<?php

namespace Database\Factories;


use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserHistorySupport>
 */
class UserHistorySupportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'user_support_id' => Admin::query()->inRandomOrder()->first()->id,
            'support_role' => Role::query()->inRandomOrder()->first()->id,
            'description' => null,
            'start_time' => $startTime = $this->faker->dateTime,
            'end_time' => $endTime = Carbon::parse($startTime)->addDays(rand(1, 30)),
            'expired_at' => $this->faker->randomElement([null, $endTime->addDays(rand(1, 5))])
        ];
    }
}
