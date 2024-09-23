<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Task;

class EventSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            'email' => 'phplanner.project@gmail.com', // Mailtrap email
        ]);

        $event1 = Event::factory()->create([
            'title' => 'Reunião com Equipe I',
            'description' => 'Reunião destinada a revisar estratégias de projeto e alinhar objetivos entre a equipe',
            'start' =>  '2024-09-25 09:00:00',
            'user_id' => $user->id,
        ]);

        $event2 = Event::factory()->create([
            'title' => 'Compras',
            'description' => 'Importante: comprar materias de limpeza, comida para o cachoro e lâmpada para a sala',
            'start' =>  '2024-09-24 10:00:00',
            'user_id' => $user->id,
        ]);

        Task::factory()->create(['event_id' => $event1->id, 'duration' => 'half hour', 'status' => 'ongoing']);
        Task::factory()->create(['event_id' => $event2->id, 'duration' => 'hour', 'status' => 'ongoing']);
    }
}
