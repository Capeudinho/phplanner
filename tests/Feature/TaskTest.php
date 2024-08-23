<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
	use RefreshDatabase;

	public function test_task_can_be_indexed(): void
	{
		$user = User::factory()->create();
		Task::factory()->for(Event::factory()->for($user))->create();
		$response = $this->actingAs($user)->get(route('task.index'));
		$response->assertOk();
	}

	public function test_task_can_be_shown(): void
	{
		$user = User::factory()->create();
		$task = Task::factory()->for(Event::factory()->for($user))->create();
		$response = $this->actingAs($user)->get(route('task.show', $task->id));
		$response->assertOk();
	}

	public function test_task_can_be_stored(): void
	{
		$user = User::factory()->create();
		$task = Task::factory()->for(Event::factory()->for($user))->create();
		$data = array_merge($task->toArray(), $task->event->toArray());
		$response = $this->actingAs($user)->post(route('task.store'), $data);
		$response->assertOk();
	}

	public function test_task_can_be_updated(): void
	{
		$user = User::factory()->create();
		$task = Task::factory()->for(Event::factory()->for($user))->create();
		$data = array_merge($task->toArray(), $task->event->toArray());
		$response = $this->actingAs($user)->put(route('task.update', $task->id), $data);
		$response->assertOk();
	}

	public function test_task_can_be_destroyed(): void
	{
		$user = User::factory()->create();
		$task = Task::factory()->for(Event::factory()->for($user))->create();
		$response = $this->actingAs($user)->delete(route('task.destroy', $task->id));
		$response->assertOk();
	}
}
