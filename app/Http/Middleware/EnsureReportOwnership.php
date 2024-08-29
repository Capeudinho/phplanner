<?php

namespace App\Http\Middleware;

use App\Models\ReportController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureReportOwnership {
    /**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
    public function handle(Request $request, Closure $next): Response {
		if ($request->exists('id')) {
			$report = Report::find($request->route('report'));
			if ($report && $report->event->user_id !== Auth::id()) {
				abort(403);
			}
		}
		return $next($request);
	}
}