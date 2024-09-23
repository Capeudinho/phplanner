<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

	public function index()
	{
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
				'aliases' => ['Semana', 'Quantidade'],
				'results' => [],
			],
			'productiveTurns' => [
				'title' => 'Turnos mais produtivos (em ordem)',
				'aliases' => ['Turno', 'Quantidade'],
				'results' => [],
			],
			'finishedTaskCategories' => [
				'title' => 'Categorias de tarefas mais realizadas (em ordem)',
				'aliases' => ['Categoria', 'Quantidade'],
				'results' => [],
			],
			'finishedGoalCategories' => [
				'title' => 'Categorias de metas mais realizadas (em ordem)',
				'aliases' => ['Categoria', 'Quantidade'],
				'results' => [],
			],
		];

		$reports['finishedTasks']['results'] = DB::select(
			'SELECT COUNT(*) AS quantity, (CAST(COUNT(*) AS FLOAT)/(
				SELECT COUNT(*)
				FROM users u, events e, tasks t
				WHERE u.id = ' . $id .
				' AND u.id = e.user_id
				AND e.id = t.event_id
				AND e.start >= NOW()-INTERVAL \'365 DAYS\'
				AND e.start <= NOW()))*100 AS percent
			FROM users u, events e, tasks t
			WHERE u.id = ?
			AND u.id = e.user_id
			AND e.id = t.event_id
			AND t.status = \'finished\'
			AND e.start >= NOW()-INTERVAL \'365 DAYS\'
			AND e.start <= NOW()',
            [$id]
		);

		$reports['productiveTurns']['results'] = DB::select(
			'SELECT CASE
        		WHEN EXTRACT(HOUR FROM e.start) >= 0 AND EXTRACT(HOUR FROM e.start) < 6 THEN \'Madrugada\'
        		WHEN EXTRACT(HOUR FROM e.start) >= 6 AND EXTRACT(HOUR FROM e.start) < 12 THEN \'Manhã\'
        		WHEN EXTRACT(HOUR FROM e.start) >= 12 AND EXTRACT(HOUR FROM e.start) < 18 THEN \'Tarde\'
        		ELSE \'Noite\'
    		END AS turn,
			COUNT(*) AS quantity
			FROM users u, events e, tasks t
			WHERE u.id = ?
			AND u.id = e.user_id
			AND e.id = t.event_id
			AND t.status = \'finished\'
			AND e.start >= NOW()-INTERVAL \'365 DAYS\'
			AND e.start <= NOW()
			GROUP BY turn
			ORDER BY COUNT(*) DESC',
            [$id]
		);

		$reports['finishedTaskCategories']['results'] = DB::select(
            'SELECT c.name, COUNT(*) AS quantity
            FROM events e
            INNER JOIN categories c ON e.category_id = c.id
            INNER JOIN tasks t ON t.event_id = e.id
            WHERE e.user_id = ?
			AND e.start >= NOW()-INTERVAL\'365 DAYS\'
			AND e.start <= NOW()
            AND t.status = \'finished\'
            GROUP BY c.id, c.name
            ORDER BY quantity DESC',
            [$id]
        );

		$reports['finishedGoalCategories']['results'] = DB::select(
            'SELECT c.name,COUNT(*) AS quantity
            FROM events e
            INNER JOIN categories c ON e.category_id = c.id
            INNER JOIN goals g ON g.event_id = e.id
            WHERE e.user_id = ?
			AND e.start >= NOW()-INTERVAL \'365 DAYS\'
			AND e.start <= NOW()
            AND g.status = \'succeeded\'
            GROUP BY c.id, c.name
            ORDER BY quantity DESC',
            [$id]
        );

		return view('report.index', compact('reports'));
	}
}
