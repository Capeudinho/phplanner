<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Goal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoalTest extends TestCase
{
	use RefreshDatabase;

	public function test_goal_can_be_indexed(): void
	{
		$user = User::factory()->create();
		Goal::factory()->for(Event::factory()->for($user))->create();
		$response = $this->actingAs($user)->get(route('goal.index'));
		$response->assertOk();
	}

	public function test_goal_can_be_shown(): void
	{
		$user = User::factory()->create();
		$goal = Goal::factory()->for(Event::factory()->for($user))->create();
		$response = $this->actingAs($user)->get(route('goal.show', $goal->id));
		$response->assertOk();
	}

	public function test_goal_can_be_stored(): void
	{
		$user = User::factory()->create();
		$goal = Goal::factory()->for(Event::factory()->for($user))->create();
		$data = array_merge($goal->toArray(), $goal->event->toArray());
		$response = $this->actingAs($user)->post(route('goal.store'), $data);
		$response->assertOk();
	}

	public function test_goal_can_be_updated(): void
	{
		$user = User::factory()->create();
		$goal = Goal::factory()->for(Event::factory()->for($user))->create();
		$data = array_merge($goal->toArray(), $goal->event->toArray());
		$response = $this->actingAs($user)->put(route('goal.update', $goal->id), $data);
		$response->assertOk();
	}

	public function test_goal_can_be_destroyed(): void
	{
		$user = User::factory()->create();
		$goal = Goal::factory()->for(Event::factory()->for($user))->create();
		$response = $this->actingAs($user)->delete(route('goal.destroy', $goal->id));
		$response->assertOk();
	}
}
