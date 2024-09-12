<?php

namespace App\Listeners;

use App\Events\TaskEndingSoon;
use App\Mail\TaskEndingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskEndingMail implements ShouldQueue
{
    public function handle(TaskEndingSoon $event)
    {
        $task = $event->task;
        Mail::to($task->user->email)->send(new TaskEndingMail($task));
    }
}
