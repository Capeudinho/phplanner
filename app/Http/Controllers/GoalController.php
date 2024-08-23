<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalCreateRequest;
use App\Http\Requests\GoalUpdateRequest;
use App\Models\Event;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalController extends Controller
{

	public function index()
	{
		$goals = Goal::with('event')->where('user_id', Auth::id());
		// return view('goal.index', compact('category'));
	}

	public function create()
	{
		// return view('goal.create', compact('category'));
	}

	public function store(GoalCreateRequest $request)
	{
		$data = $request->validated();
		DB::transaction(function () use ($data) {
			$event = new Event();
			$event->title = $data['title'];
			$event->description = $data['description'];
			$event->start = $data['start'];
			$event->category_id = $data['category_id'] ?? null;
			$event->user_id = Auth::id();
			$event->save();
			$goal = new Goal();
			$goal->duration = $data['duration'];
			$goal->status = $data['status'];
			$goal->event_id = $event->id;
			$goal->save();
		});
		// return redirect()->route('goal.index');
	}

	public function show(string $id)
	{
		$goal = Goal::with('event')->find($id);
		// return view('goals.show', compact('category'));
	}

	public function edit(string $id)
	{
		// return view('goal.edit', compact('category'));
	}

	public function update(GoalUpdateRequest $request, string $id)
	{
		$data = $request->validated();
		DB::transaction(function () use ($id, $data) {
			$goal = Goal::find($id);
			$goal->duration = $data['duration'] ?? $goal->duration;
			$goal->status = $data['status'] ?? $goal->status;
			$goal->save();
			$event = Event::find($goal->event_id);
			$event->title = $data['title'] ?? $event->title;
			$event->description = $data['description'] ?? $event->description;
			$event->start = $data['start'] ?? $event->start;
			$event->category_id = $data['category_id'] ?? $event->category_id;
			$event->save();
		});
		// return redirect()->route('goal.index');
	}

	public function destroy(string $id)
	{
		$goal = Goal::find($id);
		$event = Event::find($goal->event->id);
		$event->delete();
		// return redirect()->route('goal.index');
	}
}
