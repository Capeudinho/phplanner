<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskEndingSoon
{
    use Dispatchable, SerializesModels;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }
}