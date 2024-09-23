@extends('mails.mail')

@section('content')
    <h2 style="color: #333;">Lembrete semanal de tarefas</h2>
    <p>Olá, {{$name}}.</p>
    
    <p>Você tem algumas tarefas importantes se aproximando! Aqui está uma visão geral do que está por vir esta semana.</p>
    
    <?php 
    $durationTranslations = [
        \App\Enums\TaskDuration::HALF_HOUR->value => '30 minutos',
        \App\Enums\TaskDuration::HOUR->value => '1 hora',
        \App\Enums\TaskDuration::TURN->value => '1 turno',
    ];

    $statusTranslations = [
        \App\Enums\TaskStatus::FINISHED->value => 'Concluída',
        \App\Enums\TaskStatus::ONGOING->value => 'Em progresso',
        \App\Enums\TaskStatus::DELAYED->value => 'Pendente',
    ]; 
    ?>

    <ul style="list-style: none; padding: 0;">
        @foreach($events as $event)
            <li style="margin-bottom: 20px; padding: 13px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">
                <span style="font-weight: bold; font-size: 15px;">{{ $event->title }}</span><br>
                <span style="font-weight: bold; font-size: 13px;">Quando:</span>
                <span style="font-size: 13px;">{{ \Carbon\Carbon::parse($event->start)->format('d/m/Y H:i') }}</span><br>
                <span style="font-weight: bold; font-size: 13px;">Duração:</span>
                <span style="font-size: 13px;">{{ $durationTranslations[$event->task->duration] }}</span><br>
                <span style="font-weight: bold; font-size: 13px;">Status:</span>
                <span style="font-size: 13px;">{{ $statusTranslations[$event->task->status] }}</span><br>
                <span style="font-weight: bold; font-size: 13px;">Descrição:</span>
                <span style="font-size: 13px;">{{ $event->description }}</span>
            </li>
        @endforeach
    </ul>
    
@endsection
