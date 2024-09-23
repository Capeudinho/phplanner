<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {

    public function index() {
		$id = Auth::id();
		$reports = [
			'finishedGoals' => [
				'title' => 'Quantidade e porcentagem de metas finalizadas',
				'aliases' => ['Quantidade', "Porcentagem"],
				'results' => [],
			],
			'finishedTasks' => [
				'title' => 'Quantidade e porcentagem de tarefas finalizadas',
				'aliases' => ['Quantidade', "Porcentagem"],
				'results' => [],
			],
			'productiveWeeks' => [
				'title' => 'Semanas mais produtivas (em ordem)',
				'aliases' => ['Semana'],
				'results' => [],
			],
			'productiveTurns' => [
				'title' => 'Turnos mais produtivos (em ordem)',
				'aliases' => ['Turno'],
				'results' => [],
			],
			'finishedTaskCategories' => [
				'title' => 'Categorias de tarefas mais realizadas (em ordem)',
				'aliases' => ['Categoria'],
				'results' => [],
			],
			'finishedGoalCategories' => [
				'title' => 'Categorias de metas mais realizadas (em ordem)',
				'aliases' => ['Categoria'],
				'results' => [],
			],
		];

		$reports['finishedTasks']['results'] = DB::select(
			'SELECT COUNT(*) AS quantidade, (CAST(COUNT(*) AS FLOAT)/(
				SELECT COUNT(*)
				FROM users u, events e, tasks t
				WHERE u.id = '.$id.
				' AND u.id = e.user_id
				AND e.id = t.event_id
				AND e.start >= NOW() - INTERVAL \'365 DAYS\'))*100 AS porcentagem
			FROM users u, events e, tasks t
			WHERE u.id = '.$id.
			' AND u.id = e.user_id
			AND e.id = t.event_id
			AND t.status = \'finished\'
			AND e.start >= NOW() - INTERVAL \'365 DAYS\'');

		$reports['productiveTurns']['results'] = DB::select(
			'SELECT CASE
        		WHEN EXTRACT(HOUR FROM e.start) >= 0 AND EXTRACT(HOUR FROM e.start) < 6 THEN \'Madrugada\'
        		WHEN EXTRACT(HOUR FROM e.start) >= 6 AND EXTRACT(HOUR FROM e.start) < 12 THEN \'Manhã\'
        		WHEN EXTRACT(HOUR FROM e.start) >= 12 AND EXTRACT(HOUR FROM e.start) < 18 THEN \'Tarde\'
        		ELSE \'Noite\'
    		END AS turn
			FROM users u, events e, tasks t
			WHERE u.id = '.$id.
			' AND u.id = e.user_id
			AND e.id = t.event_id
			AND t.status = \'finished\'
			AND e.start >= NOW() - INTERVAL \'365 DAYS\'
			GROUP BY turn
			ORDER BY COUNT(*) DESC');

        return view('report.index', compact('reports'));
    }
}