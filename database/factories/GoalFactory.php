<?php

namespace Database\Factories;

use App\Enums\GoalDuration;
use App\Enums\GoalStatus;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'duration' => fake()->randomElement(GoalDuration::values()),
            'status' => fake()->randomElement(GoalStatus::values()),
            'event_id' => Event::factory(),
        ];
    }
}
