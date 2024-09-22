@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">

    <div class="flex">
        <h1 class="text-2xl mb-4">
            Suas metas
        </h1>
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
                href="{{ route('goal.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon" >
                Cadrastrar meta
            </a>


        </div>
        @include('components.table', [
            'header' => ['ID', 'Título', 'Descrição', 'Data de início', 'Duração', 'Status', 'Categoria'],
            'content' => $goals->map(function($goal) {
                $durationTranslations = [
                    'week' => '1 semana',
                    'month' => '1 mês',
                    'year' => '1 ano',
                ];

                $statusTranslations = [
                    'succeeded' => 'Atingida',
                    'partially succeeded' => 'Parcialmente atingida',
                    'failed' => 'Não atingida',
                ];

                return [
					$goal->id,
                    $goal->event->title,
                    $goal->event->description,
                    $goal->event->start,
                    $durationTranslations[$goal->duration] ?? $goal->duration, 
                    $statusTranslations[$goal->status] ?? $goal->status,
                    $goal->event->category != null ? ['name' => $goal->event->category->name, 'color' => $goal->event->category->color] : '',              
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
