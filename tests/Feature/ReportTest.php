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

    public function test_index()
	{
		$user = User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com',]);
		$taskEvent1 = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 00:00:00'])->create();
		$taskEvent2 = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 00:00:00'])->create();
		$taskEvent3 = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 12:00:00'])->create();
		$taskEvent4 = Event::factory(['user_id' => $user->id, 'start' => '2024-09-10 12:00:00'])->create();
		Task::factory(['event_id' => $taskEvent1->id, 'status' => TaskStatus::FINISHED])->create();
		Task::factory(['event_id' => $taskEvent2->id, 'status' => TaskStatus::DELAYED])->create();
		Task::factory(['event_id' => $taskEvent3->id, 'status' => TaskStatus::FINISHED])->create();
		Task::factory(['event_id' => $taskEvent4->id, 'status' => TaskStatus::FINISHED])->create();

		$response = $this->actingAs($user)->get(route('report.index'));
		$response->assertOk();
    }
}
