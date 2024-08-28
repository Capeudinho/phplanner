@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">

    <div class="flex">
        <h1 class="text-2xl mb-4">
            Suas Metas
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
            <div class="flex items-center ">
                <select id="statusFilter" onchange="filterByStatus()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">
                    <option value="">Todos os Estatus</option>
                    <option value="succeeded">Atingida</option>
                    <option value="partially succeeded">Parcialmente Atingida</option>
                    <option value="failed">Não Atingida</option>
                </select>
            </div>
        </div>


            <a
                href="{{ route('goal.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Criar Nova Meta
            </a>


        </div>
        @include('components.table', [
            'header' => ['ID', 'Titulo', 'Descrição','Data de Inicio', 'Duração', 'Estatus',  'Categoria'],
            'content' => $goals->map(function($goals) {
                $durationTranslations = [
                    'week' => 'Semana',
                    'month' => 'Mês',
                    'year' => 'Ano',
                ];

                $statusTranslations = [
                    'succeeded' => 'Atingida',
                    'partially succeeded' => 'Parcialmente Atingida',
                    'failed' => 'Não Atingida',
                ];

                return [
                    $goals->id,
                    $goals->event->title,
                    $goals->event->description,
                    $goals->event->start, 
                    $durationTranslations[$goals->duration] ?? $goals->duration, 
                    $statusTranslations[$goals->status] ?? $goals->status,
                    $goals->event->category,              
                ];
            }),
            'editRoute' => 'goal.edit',
            'deleteRoute' => 'goal.destroy',
        ])
        
    </div>

<script>
    function filterByStatus() {
        const filterValue = document.getElementById("statusFilter").value;
        const url = filterValue ? `/goals/filter/${filterValue}` : '/goals'; 
        window.location.href = url;
    }
</script>

@endsection

@push('scripts')
    <script src="/js/searchtable.js"></script>
@endpush
