<?php

namespace Database\Factories;

use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ClassesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'holding_date'           => Carbon::now()->addDays(rand(1, 30))->addHours(rand(1,24))->addMinutes(rand(1, 60)),
            'status'                 => Arr::random(array_keys(Classes::statuses)),
            'parent_id'              => null,
            'studio_description'     => fake()->sentence() . fake()->sentence(),
            'qa_is_active'           => Arr::random([true, false]),
            'homework_is_active'     => Arr::random([true, false]),
            'homework_is_mandatory'  => Arr::random([true, false]),
            'report_is_mandatory'    => Arr::random([true, false]),
            'is_free'                => Arr::random([true, false]),
            'offline_link_woza'      => Arr::random([$this->faker->url, null]),
            'offline_link_vod'       => Arr::random([$this->faker->url, null]),
            'emergency_link'         => Arr::random([$this->faker->url, null]),
            'attached_file_link'     => Arr::random([$this->faker->url, null]),
        ];
    }

    public function course_id($course_id): Factory
    {
        return $this->state(function(array $attributes) use ($course_id){
            return [
                'course_id' => $course_id
            ];
        });
    }
}
