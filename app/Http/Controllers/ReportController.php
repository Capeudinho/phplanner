<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

	public function index()
	{
		$id = Auth::id();

		foreach (['7', '30', '365'] as $interval) {

			$reports[$interval]['finishedGoals'] = [
				'title' => 'Quantidade e porcentagem de metas cumpridas',
				'aliases' => ['Quantidade', 'Porcentagem'],
				'results' => [],
			];

			$reports[$interval]['finishedGoals']['results'] = DB::select(
				'SELECT COUNT(*) AS quantity, CASE 
					WHEN (
						SELECT COUNT(*)
						FROM users u, events e, goals g
						WHERE u.id = '.$id.
						' AND u.id = e.user_id
						AND e.id = g.event_id
						AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
						AND e.start <= NOW()) = 0
					THEN NULL
					ELSE (CAST(COUNT(*) AS FLOAT)/(
						SELECT COUNT(*)
						FROM users u, events e, goals g
						WHERE u.id = '.$id.
						' AND u.id = e.user_id
						AND e.id = g.event_id
						AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
						AND e.start <= NOW()
					))*100
				END AS percent
				FROM users u, events e, goals g
				WHERE u.id = '.$id.
				' AND u.id = e.user_id
				AND e.id = g.event_id
				AND g.status = \'finished\'
				AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
				AND e.start <= NOW()'
			);

			$reports[$interval]['finishedTasks'] = [
				'title' => 'Quantidade e porcentagem de tarefas cumpridas',
				'aliases' => ['Quantidade', 'Porcentagem'],
				'results' => [],
			];

			$reports[$interval]['finishedTasks']['results'] = DB::select(
				'SELECT COUNT(*) AS quantity, CASE 
					WHEN (
						SELECT COUNT(*)
						FROM users u, events e, tasks t
						WHERE u.id = '.$id.
						' AND u.id = e.user_id
						AND e.id = t.event_id
						AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
						AND e.start <= NOW()) = 0
					THEN NULL
					ELSE (CAST(COUNT(*) AS FLOAT)/(
						SELECT COUNT(*)
						FROM users u, events e, tasks t
						WHERE u.id = '.$id.
						' AND u.id = e.user_id
						AND e.id = t.event_id
						AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
						AND e.start <= NOW()
					))*100
				END AS percent
				FROM users u, events e, tasks t
				WHERE u.id = '.$id.
				' AND u.id = e.user_id
				AND e.id = t.event_id
				AND t.status = \'finished\'
				AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
				AND e.start <= NOW()'
			);

			if ($interval == '365') {

				$reports[$interval]['productiveMonths'] = [
					'title' => 'Meses mais produtivos',
					'aliases' => ['Mês', 'Quantidade'],
					'results' => [],
				];
			
				$reports[$interval]['productiveMonths']['results'] = DB::select(
					'SELECT EXTRACT(MONTH FROM e.start) AS month,
					COUNT(*) AS tasks_count
					FROM users u, events e, tasks t
					WHERE u.id = '.$id.
					' AND u.id = e.user_id
					AND e.id = t.event_id
					AND t.status = \'finished\'
					AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
					AND e.start <= NOW()
					GROUP BY month
					ORDER BY tasks_count DESC'
				);

				$reports[$interval]['productiveWeeks'] = [
					'title' => 'Semanas mais produtivas',
					'aliases' => ['Mês', 'Semana', 'Quantidade'],
					'results' => [],
				];

				$reports[$interval]['productiveWeeks']['results'] = DB::select(
					'SELECT
						EXTRACT(MONTH FROM e.start) AS month,
						CEIL(EXTRACT(DAY FROM e.start) / 7) AS week,
						COUNT(*) AS tasks_count
					FROM users u, events e, tasks t
					WHERE u.id = '.$id.
					' AND u.id = e.user_id
					AND e.id = t.event_id
					AND t.status = \'finished\'
					AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
					AND e.start <= NOW()
					GROUP BY month, week
					ORDER BY tasks_count DESC'
				);

			} else if ($interval == '30') {

				$reports[$interval]['productiveWeeks'] = [
					'title' => 'Semanas mais produtivas',
					'aliases' => ['Semana', 'Quantidade'],
					'results' => [],
				];

				$reports[$interval]['productiveWeeks']['results'] = DB::select(
					'SELECT
						CEIL(EXTRACT(DAY FROM e.start) / 7) AS week,
						COUNT(*) AS tasks_count
					FROM users u, events e, tasks t
					WHERE u.id = '.$id.
					' AND u.id = e.user_id
					AND e.id = t.event_id
					AND t.status = \'finished\'
					AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
					AND e.start <= NOW()
					GROUP BY week
					ORDER BY tasks_count DESC'
				);

			}

			$reports[$interval]['productiveTurns'] = [
				'title' => 'Turnos mais produtivos',
				'aliases' => ['Turno', 'Quantidade'],
				'results' => [],
			];

			$reports[$interval]['productiveTurns']['results'] = DB::select(
				'SELECT CASE
					WHEN EXTRACT(HOUR FROM e.start) >= 0 AND EXTRACT(HOUR FROM e.start) < 6 THEN \'Madrugada\'
					WHEN EXTRACT(HOUR FROM e.start) >= 6 AND EXTRACT(HOUR FROM e.start) < 12 THEN \'Manhã\'
					WHEN EXTRACT(HOUR FROM e.start) >= 12 AND EXTRACT(HOUR FROM e.start) < 18 THEN \'Tarde\'
					ELSE \'Noite\'
				END AS turn,
				COUNT(*) AS quantity
				FROM users u, events e, tasks t
				WHERE u.id = '.$id.
				' AND u.id = e.user_id
				AND e.id = t.event_id
				AND t.status = \'finished\'
				AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
				AND e.start <= NOW()
				GROUP BY turn
				ORDER BY COUNT(*) DESC'
			);

			$reports[$interval]['finishedTaskCategories'] = [
				'title' => 'Categorias de tarefas mais realizadas',
				'aliases' => ['Categoria', 'Quantidade'],
				'results' => [],
			];

			$reports[$interval]['finishedTaskCategories']['results'] = DB::select(
				'SELECT c.name, COUNT(*) AS quantity
				FROM events e
				INNER JOIN categories c ON e.category_id = c.id
				INNER JOIN tasks t ON t.event_id = e.id
				WHERE e.user_id = '.$id.
				' AND e.start >= NOW() - INTERVAL\''.$interval.' DAYS\'
				AND e.start <= NOW()
				AND t.status = \'finished\'
				GROUP BY c.id, c.name
				ORDER BY quantity DESC'
			);

			$reports[$interval]['finishedGoalCategories'] = [
				'title' => 'Categorias de metas mais realizadas',
				'aliases' => ['Categoria', 'Quantidade'],
				'results' => [],
			];

			$reports[$interval]['finishedGoalCategories']['results'] = DB::select(
				'SELECT c.name,COUNT(*) AS quantity
				FROM events e
				INNER JOIN categories c ON e.category_id = c.id
				INNER JOIN goals g ON g.event_id = e.id
				WHERE e.user_id = '.$id.
				' AND e.start >= NOW() - INTERVAL \''.$interval.' DAYS\'
				AND e.start <= NOW()
				AND g.status = \'succeeded\'
				GROUP BY c.id, c.name
				ORDER BY quantity DESC'
			);
		}

		return view('report.index', compact('reports'));
	}
}
