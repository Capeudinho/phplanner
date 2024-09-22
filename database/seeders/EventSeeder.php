<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'phplanner.project@gmail.com', // Mailtrap email
        ]);

        $event1 = Event::factory()->create([
            'title' => 'Very Important Meeting',
            'description' => 'Meeting about those very important things.',
            'start' => now()->startOfWeek()->addWeek(),
            'user_id' => $user->id,
        ]);

        $event2 = Event::factory()->create([
            'title' => 'Groceries',
            'description' => 'Need cleaning supplies.',
            'start' => now()->startOfWeek()->addWeek(),
            'user_id' => $user->id,
        ]);

        $event1->task()->create([
            'duration' => 'half hour',
            'status' => 'ongoing',
        ]);

        $event2->task()->create([
            'duration' => 'hour',
            'status' => 'ongoing',
        ]);
    }
}
