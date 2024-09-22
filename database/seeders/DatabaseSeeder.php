<?php

namespace Database\Seeders;

use App\Enums\GoalDuration;
use App\Enums\TaskDuration;
use App\Enums\GoalStatus;
use App\Enums\TaskStatus;
use App\Models\Event;
use App\Models\Goal;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
           EventSeeder::class,
        ]);

		$user = User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com',]);
		$taskEvent = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 00:00:00'])->create();
		$goalEvent = Event::factory(['user_id' => $user->id, 'start' => '2024-09-04 00:00:00'])->create();
		Task::factory(['event_id' => $taskEvent->id, 'duration' => TaskDuration::HOUR, 'status' => TaskStatus::FINISHED])->create();
		Goal::factory(['event_id' => $goalEvent->id, 'duration' => GoalDuration::WEEK, 'status' => GoalStatus::SUCCEEDED])->create();
    }
}
