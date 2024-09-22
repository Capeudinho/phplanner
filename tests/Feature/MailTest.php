<?php

namespace Tests\Feature;


use App\Models\Event;
use App\Models\User;
use Tests\TestCase;
use App\Http\Controllers\MailController;
use App\Mail\WeeklyReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_weekly_reminder_email()
    {
        Mail::fake([WeeklyReminder::class]);

        $user = User::factory()->create([
            'email' => 'phplanner.project@gmail.com', // Mailtrap email
        ]);

        $event = Event::factory()->create([
            'title' => 'Very Important Meeting',
            'description' => 'Meeting about those very important things.',
            'start' => now()->startOfWeek()->addWeek(),
            'user_id' => $user->id,
        ]);
        
        $event->task()->create(['duration' => 'half hour', 'status' => 'ongoing']);

        $controller = new MailController();
        $response = $controller->sendWeeklyReminderEmail();
        $this->assertEquals("Weekly reminder email sent successfully!", $response);

        Mail::assertSent(WeeklyReminder::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}