@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">
        <div class="flex">
            <h1 class="text-2xl mb-4">
                Suas categorias
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
                href="{{ route('category.create') }}"
                class="add-button"
            >
                <img src="{{ asset('icons/plus.svg') }}" alt="Add Icon">
                Cadastrar categoria
            </a>
        </div>

        @include('components.table', [
        'header' => ['ID', 'Nome', 'Cor'],
        'content' => $categories->map(function ($category) {
            $colorTranslations = [
                '#CC0000' => 'Vermelho',
                '#CC6600' => 'Laranja',
                '#CCCC00' => 'Amarelo',
                '#66CC00' => 'Lima',
                '#00CC00' => 'Verde',
                '#00CC66' => 'Menta',
                '#00CCCC' => 'Ciano',
                '#0066CC' => 'Azure',
                '#0000CC' => 'Azul',
                '#6600CC' => 'Roxo',
                '#CC00CC' => 'Magenta',
                '#CC0066' => 'Rosa',
            ];
    
            return [
                $category->id,
                ['name' => $category->name, 'color' => $category->color],
                ['name' => $colorTranslations[$category->color] ?? $category->color, 'color' => $category->color],
            ];
        }),
        'editRoute' => 'category.edit',
        'deleteRoute' => 'category.destroy',
    ])

    </div>

    
@endsection

@push('scripts')
    <script src="/js/searchtable.js"></script>
@endpush
