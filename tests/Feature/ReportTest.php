<?php

namespace Tests\Feature;

use App\Enums\GoalDuration;
use App\Enums\GoalStatus;
use App\Enums\TaskDuration;
use App\Enums\TaskStatus;
use Tests\TestCase;
use App\Models\User;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_finished_tasks()
	{
		$user = User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com',]);
		$taskEvent1 = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 00:00:00'])->create();
		$taskEvent2 = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 00:00:00'])->create();
		Task::factory(['event_id' => $taskEvent1->id, 'duration' => TaskDuration::HOUR, 'status' => TaskStatus::FINISHED])->create();
		Task::factory(['event_id' => $taskEvent2->id, 'duration' => TaskDuration::HOUR, 'status' => TaskStatus::DELAYED])->create();


		$response = $this->actingAs($user)->get(route('report.index'));
		$response->assertOk();
    }
}
