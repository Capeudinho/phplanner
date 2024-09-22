<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalCreateRequest;
use App\Http\Requests\GoalUpdateRequest;
use App\Models\Event;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Category;

class GoalController extends Controller
{

	public function index()
	{
		$goals = Goal::with('event')->whereHas('event', function ($query) {$query->where('user_id', Auth::id());})->get();
		return view('goal.index', compact('goals'));
	}

	public function create()
	{
		$categories = Category::where('user_id', Auth::id())->get();
		return view('goal.create', compact('categories'));
	}

	public function store(GoalCreateRequest $request)
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
			$goal = new Goal();
			$goal->duration = $data['duration'];
			$goal->status = $data['status'];
			$goal->event_id = $event->id;
			$goal->save();
		});
		return Redirect::route('goal.index')->with('success', 'Meta criada com sucesso.');
	}

	public function show(string $id)
	{
		$goal = Goal::with('event')->findOrFail($id);
	
		return view('goal.show', compact('goal'));
	}
	
	public function edit(string $id)
	{
		$goal = Goal::with('event')->findOrFail($id);
		$categories = Category::where('user_id', Auth::id())->get();
	
		return view('goal.edit', compact(['goal', 'categories']));
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
			$event->category_id = $data['category_id'];
			$event->save();
		});
		return Redirect::route('goal.index')->with('success', 'Meta atualizada com sucesso.');
	}

	public function destroy(string $id)
	{
		$goal = Goal::find($id);
		$event = Event::find($goal->event->id);
		$event->delete();
		return Redirect::route('goal.index')->with('success', 'Meta excluida com sucesso.');
	}

	public function filterByStatus(string $status)
	{
		$goals = Goal::with('event')->whereHas('event', function ($query) {
			$query->where('user_id', Auth::id());
		})->where('status', $status)->get();

		return view('goal.index', compact('goals'));
	}

}
