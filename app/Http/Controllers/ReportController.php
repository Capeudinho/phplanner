<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {

    public function index() {
		$id = Auth::id();
		$reports = [];
		$reports['finishedTasks'] = DB::select(
			'SELECT COUNT(*) AS quantidade, (CAST(COUNT(*) AS FLOAT)/(
				SELECT COUNT(*)
				FROM users u, events e, tasks t
				WHERE u.id = '.$id.
				' AND u.id = e.user_id
				AND e.id = t.event_id
				AND e.start >= NOW() - INTERVAL \'7 days\'))*100 AS porcentagem
			FROM users u, events e, tasks t
			WHERE u.id = '.$id.
			' AND u.id = e.user_id
			AND e.id = t.event_id
			AND t.status = \'finished\'
			AND e.start >= NOW() - INTERVAL \'7 days\'');
		var_dump($reports['finishedTasks']);
        // return view('report.index', compact('reports'));
    }
}