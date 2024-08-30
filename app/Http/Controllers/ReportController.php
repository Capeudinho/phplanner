<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class ReportController extends Controller {
    public function index() {
        return view('report.index');
    }

    public function generate(Request $request) {
        $validatedTime = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'type' => ['required']
        ]);

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

    public function goalArchievedCategory(Request $request) {
        $goals = Goal::where('user_id', Auth::id())
            ->where('status', 'comSucesso')
            ->whereDate('date', '>=', $request->start_date)
            ->whereDate('date', '<=', $request->end_date);
        $categories = Category::wherein('id', $goal->pluck('category_id'))->get();

        foreach ($categories as $category) {
            $category->quantity = Goal::where('user_id', Auth::user()->id)
                ->where('status', 'comSucesso')
                ->whereDate('date', '>=', $request->start_date)
                ->whereDate('date', '<=', $request->end_date)
                ->where('category_id', $category->id)
                ->count();
            $generalQuantity = Goal::where('user_id', Auth::user()->id)
                ->where('category_id', $category->id)
                ->count();
            $category->percentage = ($category->quantity / $generalQuantity) * 100;
        }

        $categories = Arr::sort($categories, function ($category) {
            return $category->quantity;
        });

        if ($request->type == 1) {
            return view('report.goalArchievedCategory')->with([
                'categories' => $categories,
                'goal' => $goal->get(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type' => $request->type
            ]);
        }

        return view('report.quantityGoalArchieved')->with([
            'categories' => $categories,
            'goal' => $goal->get(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }

    public function taskArchievedCategory(Request $request) {
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', 'comSucesso')
            ->whereDate('date', '>=', $request->start_date)
            ->whereDate('date', '<=', $request->end_date);
        $categories = Category::wherein('id', $task->pluck('category_id'))->get();

        foreach ($categories as $category) {
            $category->quantity = Task::where('user_id', Auth::user()->id)
                ->where('status', 'comSucesso')
                ->whereDate('date', '>=', $request->start_date)
                ->whereDate('date', '<=', $request->end_date)
                ->where('category_id', $category->id)
                ->count();
            $generalQuantity = Task::where('user_id', Auth::user()->id)
                ->where('category_id', $category->id)
                ->count();
            $category->percentage = ($category->quantity / $generalQuantity) * 100;
        }

        $categories = Arr::sort($categories, function ($category) {
            return $category->quantity;
        });

        if ($request->type == 2) {
            return view('report.taskArchievedCategory')->with([
                'categories' => $categories,
                'task' => $task->get(),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type' => $request->type
            ]);
        }

        return view('report.quantityTaskArchieved')->with([
            'categories' => $categories,
            'task' => $task->get(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }

    public function mostProductiveShift(Request $request) {
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', 'comSucesso')
            ->whereDate('date', '>=', $request->start_date)
            ->whereDate('date', '<=', $request->end_date);
        $shifts = $tasks->select('shift')->distinct()->get();

        foreach ($shifts as $shift) {
            $shift->quantity = Task::where('user_id', Auth::user()->id)
                ->where('status', 'comSucesso')
                ->whereDate('date', '>=', $request->start_date)
                ->whereDate('date', '<=', $request->end_date)
                ->where('shift', $shift->shift)
                ->count();
        }

        $shifts = Arr::sort($shifts, function ($shift) {
            return $shift->quantity;
        });
        
        return view('report.mostProductiveShift')->with([
            'shifts' => $shifts,
            'task' => $task->get(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }

    public function generateYears(Request $request) {
        $start = new \DateTime($request->start_date);
        $end = new \DateTime($request->end_date);
        $years = [];

        while ($start->format('Y') <= $end->format('Y')) {
            $aux = new \stdClass();
            $aux->year = $start->format('Y');
            array_push($years, $aux);
            $start->modify('+1 year');
        }

        return $years;
    }

    public function generateMonths(Request $request) {
        $start = new \DateTime($request->start_date);
        $end = new \DateTime($request->end_date);
        $today = new \DateTime();

        foreach ($yearsTemp as $yearTemp) {
            $months = [];

            while (($start->format('m') <= 12 && $yearTemp->year == $start->format('Y')) && ($start->format('Y') <= $end->format('Y-m'))) {
                $aux = new \stdClass();
                $aux->month = $start->format('m');
                $aux->week = [];
                array_push($months, $aux);
                $start->modify('+1 month');
            }
            $yearTemp->months = $weeks;
        }
    }

    public function generateWeeks(Request $request, $date) {
        foreach ($date->months as $month) {
            $startDate = new DateTime('01-' . $month->month . '-' . $date->year);
            $monthAux = $startDate->format('m');
            $contWeek = 1;

            while ($monthAux == $startDate->format('m')) {
                $cont = 0;

                for ($i = $startDate->format('w'); $i <= $monthAux == $startDate->format('m'); $i++) {
                    $cont+=Task::where("user_id", Auth::user()->id)
                    ->where('status', 'comSucesso')
                    ->where('date', $startDate)
                    ->get()
                    ->count();
                }

                $aux = new \stdClass();
                $aux->week = $contWeek;
                $aux->quantity = $cont;

                if ($cont > 0) {
                    array_push($month->week, $aux);
                }

                $contWeek++;
            }
        }
    }

    public function mostProductivePeriod(Request $request) {
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', 'comSucesso')
            ->whereDate('date', '>=', $request->start_date)
            ->whereDate('date', '<=', $request->end_date);
        $years = $this->generateYears($request);
        $this->generateMonths($request, $years);

        foreach ($years as $year) {
            $this->generateWeeks($request, $year);
        }
        
        return view('report.mostProductivePeriod')->with([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $request->type
        ]);
    }
}