@extends('mails.mail')

@section('content')
    <h2 style="color: #333;">Lembrete Semanal de Tarefas</h2>
    <p>Olá {{$name}},</p>
    
    <p>Você tem algumas tarefas importantes se aproximando! Aqui está uma visão geral do que está por vir esta semana:</p>
    
    <?php 
    $durationTranslations = [
        \App\Enums\TaskDuration::HALF_HOUR->value => 'Meia hora',
        \App\Enums\TaskDuration::HOUR->value => 'Hora',
        \App\Enums\TaskDuration::TURN->value => 'Turno',
    ];

    $statusTranslations = [
        \App\Enums\TaskStatus::FINISHED->value => 'Concluído',
        \App\Enums\TaskStatus::ONGOING->value => 'Em andamento',
        \App\Enums\TaskStatus::DELAYED->value => 'Adiada',
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
