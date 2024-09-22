<?php

namespace App\Http\Controllers;

use App\Mail\WeeklyReminder;
use App\Models\Event;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

// controller for testing (implement scheduler later)
class MailController extends Controller
{
    public function sendWeeklyReminderEmail()
    {
        $weekStartDate = now()->startOfWeek(0);
        $weekEndDate = now()->endOfWeek(6);

        $eventsWithTasks = Event::whereBetween('start', [$weekStartDate, $weekEndDate])
        ->has('task') 
        ->with('task') 
        ->get();

        $usersWithTasks = $eventsWithTasks->groupBy('user_id');

        foreach ($usersWithTasks as $userId => $userTasks) {
            $user = User::find($userId);

            Mail::to($user->email)
                ->send(new WeeklyReminder($user->name, $userTasks));
        }

        return "Weekly reminder email sent successfully!"; 
    }
}
