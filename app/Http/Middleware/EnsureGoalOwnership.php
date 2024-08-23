<?php

namespace App\Http\Middleware;

use App\Models\Goal;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureGoalOwnership
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
			$goal = Goal::find($request->route('goal'));
			if ($goal && $goal->event->user_id !== Auth::id())
			{
				abort(403);
			}
		}
		return $next($request);
	}
}
