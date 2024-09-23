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
		$tasks = Task::with('event')->whereHas('event', function ($query) {$query->where('user_id', Auth::id());})->get();
		return view('task.index', compact('tasks'));
	}

	public function create()
	{
		$categories = Category::where('user_id', Auth::id())->get();
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
			$event->category_id = $data['category_id'];
			$event->user_id = Auth::id();
			$event->save();
			$task = new Task();
			$task->duration = $data['duration'];
			$task->status = $data['status'];
			$task->event_id = $event->id;
			$task->save();
		});
		return Redirect::route('task.index')->with('success', 'Tarefa criada com sucesso.');
	}

	public function show(string $id)
	{
		$task = Task::with('event')->find($id);
		// return view('tasks.show', compact('category'));
	}

	public function edit(string $id)
	{
		$task = Task::with('event')->findOrFail($id);
		$categories = Category::where('user_id', Auth::id())->get();

		return view('task.edit', compact(['task', 'categories']));
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
			$event->category_id = $data['category_id'];
			$event->save();
		});
		return Redirect::route('task.index')->with('success', 'Tarefa atualizada com sucesso.');
	}

	public function destroy(string $id)
	{
		$task = Task::find($id);
		$event = Event::find($task->event->id);
		$event->delete();
		return redirect()->route('task.index');
	}

	public function taskevents()
	{
	    $events = Event::whereHas('task')
			->with('task')
			->with('category')
	        ->where('user_id', Auth::id())
	        ->get()
	        ->map(function ($event) {
	            return [
					'id' => $event->task->id,
	                'title' => $event->title,
	                'start' => $event->start,
					'duration_info' => $event->task->duration,
					'description' => $event->description,
	                'status' => $event->task->status,
					'color' => $event->category ? $event->category->color : "#000000",
					'category_color' => $event->category ? $event->category->color : null, 
	                'category_name' => $event->category ? $event->category->name : null, 
	            ];
	        });

	    return response()->json($events);
	}
	
}
