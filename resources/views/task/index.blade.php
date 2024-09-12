@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">
        <div class="flex">
            <h1 class="text-2xl mb-4">
                Suas Tarefas
            </h1> 
            <img src="{{ asset('icons/pin-angle.svg') }}" alt="Ícone de Pin" class="ml-2" style="width: 20px; height: 20px;"> 
        </div>
        
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <input
                    type="text"
                    id="searchInput"
                    onkeyup="searchTable()"
                    placeholder="Pesquisar"
                    class="px-4 py-2 border border-gray-100 rounded-lg mr-2"
                /> 
            </div>

            <a
                href="{{ route('task.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon">
                Criar Nova Tarefa
            </a>
        </div>

        @include('components.table', [
            'header' => ['ID', 'Titulo', 'Descrição', 'Data de Inicio', 'Duração', 'Status', 'Categoria'],
            'content' => $tasks->map(function($task) {
                $durationTranslations = [
                    'hour' => '1 Hora',
                    'half hour' => '30 minutos',
                    'turn' => '1 turno',
                ];

                $statusTranslations = [
                    'delayed' => 'Pendente',
                    'ongoing' => 'Em Progresso',
                    'finished' => 'Concluída',
                ];

                return [
                    $task->id,
                    $task->event->title,
                    $task->event->description,
                    $task->event->start, 
                    $durationTranslations[$task->duration] ?? $task->duration, 
                    $statusTranslations[$task->status] ?? $task->status,
                    $task->event->category,            
                ];
            }),
            'editRoute' => 'task.edit',
            'deleteRoute' => 'task.destroy',
        ])
    </div>


@endsection

@push('scripts')
    <script src="/js/searchtable.js"></script>
@endpush
