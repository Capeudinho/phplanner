@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Cadastrar meta</h1>

    <form id="Form" action="{{ route('goal.store') }}" method="POST">
        @csrf

        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <label for="title" class="text-sm mb-1">Título</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('title') border-red-500 @enderror" placeholder="Título" style="margin-top: 4px">
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <label for="description" class="text-sm mb-1">Descrição</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('description') border-red-500 @enderror" placeholder="Descrição" rows="5" style="margin-top: 4px; resize: none"></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
		<div style="display: inline-block; width: 49%; margin-right: 2%;">
            <label for="start" class="text-sm mb-1">Data de início</label>
            <input type="datetime-local" name="start" id="start" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('start') border-red-500 @enderror" style="margin-top: 4px">
                @error('start')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%;">
                <label for="duration" class="text-sm mb-1">Duração</label>
                <select 
                    name="duration" 
                    id="duration" 
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('duration') border-red-500 @enderror"
                >
                    <option value="" disabled selected>Selecione uma duração</option>
                    <option value="week">1 semana</option>
                    <option value="month">1 mês</option>
                    <option value="year">1 ano</option>
                </select>
                @error('duration')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
			<div style="display: inline-block; width: 49%; margin-right: 2%;">
                <label for="status" class="text-sm mb-1">Status</label>
                <select 
                    name="status"
                    id="status"
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('status') border-red-500 @enderror"
                >
                    <option value="" disabled selected>Selecione um status</option>
                    <option value="succeeded">Atingida</option>
                    <option value="partially succeeded">Parcialmente atingida</option>
                    <option value="failed">Não atingida</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%;">
                <label for="category_id" class="text-sm mb-1">Categoria</label>
                <select 
                    name="category_id"
                    id="category_id"
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('category_id') border-red-500 @enderror"
					onchange="updateSelectColor()"
                >
                    <option value="" style="color: black">Sem categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" style="color: {{ $category->color }}" color="{{ $category->color }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('goal.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Cadastrar</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function updateSelectColor() {
        var select = document.getElementById('category_id');
        var selectedOption = select.options[select.selectedIndex];
        var color = selectedOption.getAttribute('color');
        select.style.color = color;
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateSelectColor();
    });
</script>
@endpush