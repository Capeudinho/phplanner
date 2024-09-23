<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Task;
use Tests\TestCase;
use App\Mail\WeeklyReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class MailTest extends TestCase
{
    use RefreshDatabase;
    
    public function testSendWeeklyTaskReminder()
    {
        Mail::fake([WeeklyReminder::class]);

        $user = User::factory()->create([
            'email' => 'phplanner.project@gmail.com', 
        ]);

        $event = Event::factory()->create([
            'title' => 'Reunião',
            'description' => 'Reunião importante',
            'start' => '2024-10-01 08:00:00',
            'user_id' => $user->id,
        ]);

        Task::factory()->create(['event_id' => $event->id, 'duration' => 'half hour', 'status' => 'ongoing']);
        
        Carbon::setTestNow(Carbon::create(2024, 9, 29, 00));

        $this->artisan('schedule:run');

        Mail::assertSent(WeeklyReminder::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}