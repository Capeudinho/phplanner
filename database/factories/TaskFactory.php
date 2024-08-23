<?php

namespace Database\Factories;

use App\Models\Event;
use App\Enums\TaskDuration;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'duration' => fake()->randomElement(TaskDuration::values()),
            'status' => fake()->randomElement(TaskStatus::values()),
            'event_id' => Event::factory(),
        ];
    }
}
