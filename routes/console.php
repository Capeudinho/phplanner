<?php

use Illuminate\Support\Facades\Mail;
use App\Models\Event;
use App\Models\User;
use App\Mail\WeeklyReminder;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $weekStartDate = now()->startOfWeek(0);
    $weekEndDate = now()->endOfWeek(6);

    $eventsWithTasks = Event::whereBetween('start', [$weekStartDate, $weekEndDate])
    ->has('task') 
    ->with('task') 
    ->orderBy('start')
    ->get();

    $usersWithTasks = $eventsWithTasks->groupBy('user_id');

    foreach ($usersWithTasks as $userId => $userTasks) {
        $user = User::find($userId);
       
        Mail::to($user->email)
        ->send(new WeeklyReminder($user->name, $userTasks));
    }
})->everyMinute();
