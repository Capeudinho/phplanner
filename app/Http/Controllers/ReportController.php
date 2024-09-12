<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Enums\GoalStatus;
use App\Enums\TaskStatus;
use DateTime;

class ReportController extends Controller {

    // Exibir a página inicial do relatório
    public function index() {
        return view('report.index');
    }

    // Gerar relatório com base nos parâmetros fornecidos
    public function generate(Request $request) {
        // Validar as datas e o tipo de relatório
        $validatedTime = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required']
        ]);

        // Direcionar para o método correto com base no tipo de relatório
        if ($request->type == 1 || $request->type == 4) {
            return $this->goalArchievedCategory($request);
        } else if ($request->type == 2 || $request->type == 5) {
            return $this->taskArchievedCategory($request);
        } else if ($request->type == 3) {
            return $this->mostProductiveShift($request);
        } else if ($request->type == 6) {
            return $this->mostProductivePeriod($request);
        }
    }

    // Função auxiliar para ordenar um array
    function aksort(&$array, $valrev = false, $keyrev = false) {
        if ($valrev) {
            arsort($array);
        } else {
            asort($array);
        }

        $vals = array_count_values($array);
        $i = 0;

        foreach ($vals as $val => $num) {
            $first = array_splice($array, 0, $i);
            $tmp = array_splice($array, 0, $num);

            if ($keyrev) {
                krsort($tmp);
            } else {
                ksort($tmp);
            }

            $array = array_merge($first, $tmp, $array);
            unset($tmp);
            $i += $num;
        }
    }

    // Gerar relatório de metas alcançadas por categoria
    public function goalArchievedCategory(Request $request) {
        // Buscar metas alcançadas do usuário dentro do intervalo de datas
        $goals = Goal::whereHas('event', function ($query) use ($request) {
                // Filtrar eventos pelo usuário autenticado e pelo intervalo de datas
                $query->where('user_id', Auth::id())
                    ->whereDate('start', '>=', $request->start_date) // Usar 'start' da tabela 'events'
                    ->whereDate('start', '<=', $request->end_date); // Usar 'start' da tabela 'events'
            })
            ->with('event.category') // Carregar a relação com evento e categoria
            ->where('status', GoalStatus::SUCCEEDED) // Filtrar metas com status 'SUCCEEDED'
            ->get();

        // Obter IDs das categorias a partir dos eventos das metas
        $categoryIds = $goals->pluck('event.category.id')->unique();

        // Buscar categorias correspondentes
        $categories = Category::whereIn('id', $categoryIds)->get();

        foreach ($categories as $category) {
            // Contar metas concluídas para cada categoria
            $category->quantity = $goals->filter(function ($goal) use ($category) {
                return $goal->event->category_id == $category->id;
            })->count();

            // Contar todas as metas para cada categoria
            $generalQuantity = Goal::whereHas('event', function ($query) use ($category) {
                    $query->where('user_id', Auth::id())
                        ->where('category_id', $category->id);
                })
                ->count();

            // Calcular a porcentagem de metas concluídas
            $category->percentage = ($generalQuantity > 0) ? ($category->quantity / $generalQuantity) * 100 : 0;
        }

        // Ordenar categorias pela quantidade de metas concluídas
        $categories = $categories->sortByDesc('quantity');

        // Selecionar a view com base no tipo de relatório
        $view = ($request->type == 2) ? 'report.goalArchievedCategory' : 'report.quantityGoalArchieved';

        return view($view)->with([
            'categories' => $categories,
            'goals' => $goals,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }

    // Gerar relatório de tarefas concluídas por categoria
    public function taskArchievedCategory(Request $request) {
        // Buscar tarefas concluídas do usuário dentro do intervalo de datas
        $tasks = Task::whereHas('event', function ($query) use ($request) {
                $query->where('user_id', Auth::id())
                    ->whereDate('start', '>=', $request->start_date) // Usar 'start' da tabela 'events'
                    ->whereDate('start', '<=', $request->end_date); // Usar 'start' da tabela 'events'
            })
            ->with('event.category') // Carregar a relação com evento e categoria
            ->where('status', TaskStatus::FINISHED)
            ->get();

        // Obter IDs das categorias a partir dos eventos das tarefas
        $categoryIds = $tasks->pluck('event.category.id')->unique();

        // Buscar categorias correspondentes
        $categories = Category::whereIn('id', $categoryIds)->get();

        foreach ($categories as $category) {
            // Contar tarefas concluídas para cada categoria
            $category->quantity = $tasks->filter(function ($task) use ($category) {
                return $task->event->category_id == $category->id;
            })->count();

            // Contar todas as tarefas para cada categoria
            $generalQuantity = Task::whereHas('event', function ($query) use ($category) {
                    $query->where('user_id', Auth::id())
                        ->where('category_id', $category->id);
                })
                ->count();

            // Calcular a porcentagem de tarefas concluídas
            $category->percentage = ($generalQuantity > 0) ? ($category->quantity / $generalQuantity) * 100 : 0;
        }

        // Ordenar categorias pela quantidade de tarefas concluídas
        $categories = $categories->sortByDesc('quantity');

        // Selecionar a view com base no tipo de relatório
        $view = ($request->type == 2) ? 'report.taskArchievedCategory' : 'report.quantityTaskArchieved';

        return view($view)->with([
            'categories' => $categories,
            'tasks' => $tasks,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }

    // Gerar relatório do turno mais produtivo
    public function mostProductiveShift(Request $request) {
        // Definir os turnos
        $shifts = [
            'morning' => ['start' => '06:00:00', 'end' => '14:00:00', 'shift' => 'Manha'],
            'afternoon' => ['start' => '14:00:00', 'end' => '22:00:00', 'shift' => 'Tarde'],
            'night' => ['start' => '22:00:00', 'end' => '06:00:00', 'shift' => 'Noite']
        ];

        $shiftQuantities = [];

        foreach ($shifts as $shiftName => $shiftTime) {
            // Contar tarefas concluídas em cada turno
            $shiftQuantities[$shiftName] = [
                'shift' => $shiftTime['shift'],
                'quantity' => Task::whereHas('event', function ($query) use ($request, $shiftTime) {
                    $query->where('user_id', Auth::id())
                        ->whereDate('start', '>=', $request->start_date)
                        ->whereDate('start', '<=', $request->end_date)
                        ->whereTime('start', '>=', $shiftTime['start'])
                        ->whereTime('start', '<=', $shiftTime['end']);
                })
                ->where('status', 'finished')
                ->count()
            ];
        }

        // Ordenar turnos pela quantidade de tarefas concluídas
        $shiftQuantities = array_reverse($shiftQuantities);

        // Retornar a view com os dados dos turnos
        return view('report.mostProductiveShift', [
            'shiftQuantities' => $shiftQuantities,
            'shifts' => $shiftQuantities, // Passar a variável $shifts para a view
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
    }

    // Gerar anos para o relatório de períodos mais produtivos
    public function generateYears(Request $request) {
        $start = new DateTime($request->start_date);
        $end = new DateTime($request->end_date);
        $years = [];

        while ($start->format('Y') <= $end->format('Y')) {
            $aux = new \stdClass();
            $aux->year = $start->format('Y');
            array_push($years, $aux);
            $start->modify('+1 year');
        }

        return $years;
    }

    // Gerar meses para o relatório de períodos mais produtivos
    public function generateMonths(Request $request, $yearsTemp) {
        $start = new DateTime($request->start_date);
        $end = new DateTime($request->end_date);
        $today = new DateTime();

        foreach ($yearsTemp as $yearTemp) {
            $months = [];

            while (($start->format('m') <= 12 && $yearTemp->year == $start->format('Y')) && $start->format('Y') < $end->format('Y')) {
                $aux = new \stdClass();
                $aux->month = $start->format('m');
                array_push($months, $aux);
                $start->modify('+1 month');
            }

            if ($yearTemp->year == $start->format('Y') && $start->format('Y') == $end->format('Y')) {
                while ($start->format('m') <= $end->format('m')) {
                    $aux = new \stdClass();
                    $aux->month = $start->format('m');
                    array_push($months, $aux);
                    $start->modify('+1 month');
                }
            } else if ($yearTemp->year == $start->format('Y') && $start->format('Y') == $today->format('Y')) {
                while ($start->format('m') <= $today->format('m')) {
                    $aux = new \stdClass();
                    $aux->month = $start->format('m');
                    array_push($months, $aux);
                    $start->modify('+1 month');
                }
            }

            $yearTemp->months = $months;
        }

        return $yearsTemp;
    }

    // Gerar relatório do período mais produtivo
    public function mostProductivePeriod(Request $request) {
        set_time_limit(60); // Aumentar o tempo máximo de execução para 60 segundos

        $yearsTemp = $this->generateYears($request);
        $years = $this->generateMonths($request, $yearsTemp);

        foreach ($years as $year) {
            foreach ($year->months as $month) {
                // Contar tarefas concluídas em cada mês
                $tasks = Task::whereHas('event', function ($query) use ($year, $month) {
                        $query->where('user_id', Auth::id())
                            ->whereYear('start', $year->year) // Usar 'start' da tabela 'events'
                            ->whereMonth('start', $month->month); // Usar 'start' da tabela 'events'
                    })
                    ->with('event.category') // Carregar a relação com evento e categoria
                    ->where('status', TaskStatus::FINISHED)
                    ->count();

                $month->quantity = $tasks;
            }

            // Ordenar meses pela quantidade de tarefas concluídas
            $this->aksort($year->months, true);
        }

        // Ordenar anos pela quantidade de tarefas concluídas
        $this->aksort($years, true);

        return view('report.mostProductivePeriod')->with([
            'years' => $years,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }
}