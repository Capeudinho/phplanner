<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

	public function index()
	{
		$tasks = Task::with('event')->where('user_id', Auth::id());
		// return view('task.index', compact('category'));
	}

	public function create()
	{
		// return view('task.create', compact('category'));
	}

	public function store(TaskCreateRequest $request)
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
			$task = new Task();
			$task->duration = $data['duration'];
			$task->status = $data['status'];
			$task->event_id = $event->id;
			$task->save();
		});
		// return redirect()->route('task.index');
	}

	public function show(string $id)
	{
		$task = Task::with('event')->find($id);
		// return view('tasks.show', compact('category'));
	}

	public function edit(string $id)
	{
		// return view('task.edit', compact('category'));
	}

	public function update(TaskUpdateRequest $request, string $id)
	{
		$data = $request->validated();
		DB::transaction(function () use ($id, $data) {
			$task = Task::find($id);
			$task->duration = $data['duration'] ?? $task->duration;
			$task->status = $data['status'] ?? $task->status;
			$task->save();
			$event = Event::find($task->event_id);
			$event->title = $data['title'] ?? $event->title;
			$event->description = $data['description'] ?? $event->description;
			$event->start = $data['start'] ?? $event->start;
			$event->category_id = $data['category_id'] ?? $event->category_id;
			$event->save();
		});
		// return redirect()->route('task.index');
	}

	public function destroy(string $id)
	{
		$task = Task::find($id);
		$event = Event::find($task->event->id);
		$event->delete();
		// return redirect()->route('task.index');
	}
}
