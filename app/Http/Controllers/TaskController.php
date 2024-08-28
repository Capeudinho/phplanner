<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Event;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{

	public function index()
	{
		$tasks = Task::with('event')->whereHas('event', function ($query) {
			$query->where('user_id', Auth::id());
		})->get();
		return view('task.index', compact('tasks'));
	}

	public function create()
	{
		$categories = Category::all();
		return view('task.create', compact('categories'));
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
		return Redirect::route('goal.index')->with('success', 'Meta criada com sucesso.');
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

	public function events()
{
    $events = Task::with('event')
        ->whereHas('event', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->get()
        ->map(function ($task, $category) {
            return [
				'id' => $task->id,
                'title' => $task->event->title,
                'start' => $task->event->start,
				'description' => $task->event->description,
                'status' => $task->status,
				'color' => $task->category ? $task->category->color : null, 
                'category_name' => $task->category ? $task->category->name : null, 
            ];
        });

    return response()->json($events);
}

}
