<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTaskOwnership
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if ($request->exists('id'))
		{
			$task = Task::find($request->route('task'));
			if ($task && $task->event->user_id !== Auth::id())
			{
				abort(403);
			}
		}
		return $next($request);
	}
}
