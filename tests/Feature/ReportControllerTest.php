<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Goal;
use App\Models\Task;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class ReportControllerTest extends TestCase {
    use RefreshDatabase;

    public function test_goal_archieved_category() {
        // Criar um usuário
        $user = User::factory()->create();

        // Autenticar o usuário
        Auth::login($user);

        // Criar categorias
        $category = Category::factory()->create();

        // Criar metas para a categoria
        $goal = Goal::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'finished'
        ]);

        // Fazer a requisição para o método goalArchievedCategory
        $response = $this->actingAs($user)->post('/report/goal-archieved-category', [
            'start_date' => '2023-01-01',
            'end_date' => '2023-01-02'
        ]);

        // Verificar se a view correta foi retornada
        $response->assertViewIs('report.goalArchievedCategory');

        // Verificar se os dados esperados estão presentes na view
        $response->assertViewHas('categories');
        $response->assertViewHas('start_date', '2023-01-01');
        $response->assertViewHas('end_date', '2023-01-02');
    }

    public function test_task_archieved_category() {
        // Criar um usuário
        $user = User::factory()->create();

        // Autenticar o usuário
        Auth::login($user);

        // Criar categorias
        $category = Category::factory()->create();

        // Criar eventos e tarefas para a categoria
        $event = Event::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'start' => '2023-01-01 07:00:00',
            'end' => '2023-01-01 08:00:00'
        ]);

        Task::factory()->create([
            'event_id' => $event->id,
            'status' => 'finished'
        ]);

        // Fazer a requisição para o método taskArchievedCategory
        $response = $this->actingAs($user)->post('/report/task-archieved-category', [
            'start_date' => '2023-01-01',
            'end_date' => '2023-01-02'
        ]);

        // Verificar se a view correta foi retornada
        $response->assertViewIs('report.taskArchievedCategory');

        // Verificar se os dados esperados estão presentes na view
        $response->assertViewHas('categories');
        $response->assertViewHas('start_date', '2023-01-01');
        $response->assertViewHas('end_date', '2023-01-02');
    }

    public function test_most_productive_shift() {
        // Criar um usuário
        $user = User::factory()->create();

        // Autenticar o usuário
        Auth::login($user);

        // Criar categorias
        $category = Category::factory()->create();

        // Criar eventos e tarefas para cada turno
        $shifts = [
            'morning' => ['start' => '2023-01-01 07:00:00', 'end' => '2023-01-01 08:00:00'],
            'afternoon' => ['start' => '2023-01-01 15:00:00', 'end' => '2023-01-01 16:00:00'],
            'night' => ['start' => '2023-01-01 23:00:00', 'end' => '2023-01-02 00:00:00']
        ];

        foreach ($shifts as $shiftName => $shiftTime) {
            $event = Event::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'start' => $shiftTime['start'],
                'end' => $shiftTime['end']
            ]);

            Task::factory()->create([
                'event_id' => $event->id,
                'status' => 'finished'
            ]);
        }

        // Fazer a requisição para o método mostProductiveShift
        $response = $this->actingAs($user)->post('/report/most-productive-shift', [
            'start_date' => '2023-01-01',
            'end_date' => '2023-01-02'
        ]);

        // Verificar se a view correta foi retornada
        $response->assertViewIs('report.mostProductiveShift');

        // Verificar se os dados esperados estão presentes na view
        $response->assertViewHas('shiftQuantities');
        $response->assertViewHas('start_date', '2023-01-01');
        $response->assertViewHas('end_date', '2023-01-02');

        // Verificar se os turnos estão corretos
        $shiftQuantities = $response->viewData('shiftQuantities');
        $this->assertEquals('Manha', $shiftQuantities['morning']['shift']);
        $this->assertEquals(1, $shiftQuantities['morning']['quantity']);
        $this->assertEquals('Tarde', $shiftQuantities['afternoon']['shift']);
        $this->assertEquals(1, $shiftQuantities['afternoon']['quantity']);
        $this->assertEquals('Noite', $shiftQuantities['night']['shift']);
        $this->assertEquals(1, $shiftQuantities['night']['quantity']);
    }

    public function test_most_productive_period() {
        // Criar um usuário
        $user = User::factory()->create();

        // Autenticar o usuário
        Auth::login($user);

        // Criar categorias
        $category = Category::factory()->create();

        // Criar eventos e tarefas para cada período
        $periods = [
            'morning' => ['start' => '2023-01-01 07:00:00', 'end' => '2023-01-01 08:00:00'],
            'afternoon' => ['start' => '2023-01-01 15:00:00', 'end' => '2023-01-01 16:00:00'],
            'night' => ['start' => '2023-01-01 23:00:00', 'end' => '2023-01-02 00:00:00']
        ];

        foreach ($periods as $periodName => $periodTime) {
            $event = Event::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'start' => $periodTime['start'],
                'end' => $periodTime['end']
            ]);

            Task::factory()->create([
                'event_id' => $event->id,
                'status' => 'finished'
            ]);
        }

        // Fazer a requisição para o método mostProductivePeriod
        $response = $this->actingAs($user)->post('/report/most-productive-period', [
            'start_date' => '2023-01-01',
            'end_date' => '2023-01-02'
        ]);

        // Verificar se a view correta foi retornada
        $response->assertViewIs('report.mostProductivePeriod');

        // Verificar se os dados esperados estão presentes na view
        $response->assertViewHas('periodQuantities');
        $response->assertViewHas('start_date', '2023-01-01');
        $response->assertViewHas('end_date', '2023-01-02');

        // Verificar se os períodos estão corretos
        $periodQuantities = $response->viewData('periodQuantities');
        $this->assertEquals('Manha', $periodQuantities['morning']['period']);
        $this->assertEquals(1, $periodQuantities['morning']['quantity']);
        $this->assertEquals('Tarde', $periodQuantities['afternoon']['period']);
        $this->assertEquals(1, $periodQuantities['afternoon']['quantity']);
        $this->assertEquals('Noite', $periodQuantities['night']['period']);
        $this->assertEquals(1, $periodQuantities['night']['quantity']);
    }
}