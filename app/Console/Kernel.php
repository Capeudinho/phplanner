<?php

namespace App\Console;

use App\Events\TaskEndingSoon;
use App\Models\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule (Schedule $schedule)
    {
        $schedule->call(function () {
            $tasks = Event::where('end_time', '<=', Carbon::now()->addHour())
            ->where('end_time', '>', Carbon::now())->get();

            foreach($tasks as $task) {
                event(new TaskEndingSoon($task));
            }
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}


