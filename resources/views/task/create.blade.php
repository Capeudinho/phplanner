@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">

    <h1 class="text-2xl font-normal mb-6">Cadastrar Nova Tarefa</h1>

    <form id="Form" action="{{ route('task.store') }}" method="POST">
        @csrf

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <label for="title" class="text-sm mb-1">Título da Tarefa</label>
                <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('title') border-red-500 @enderror" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <label for="start" class="text-sm mb-1">Data de Início</label>
                <input type="datetime-local" name="start" id="start" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('start') border-red-500 @enderror" required>
                @error('start')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <label for="end" class="text-sm mb-1">Data de Término</label>
                <input type="datetime-local" name="end" id="end" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('end') border-red-500 @enderror" required>
                @error('end')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <label for="priority" class="text-sm mb-1">Prioridade</label>
                <select 
                    name="priority" 
                    id="priority" 
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('priority') border-red-500 @enderror" 
                    required
                >
                    <option value="" disabled selected>Selecione a Prioridade</option>
                    <option value="low">Baixa</option>
                    <option value="medium">Média</option>
                    <option value="high">Alta</option>
                </select>
                @error('priority')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <label for="description" class="text-sm mb-1">Descrição da Tarefa</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('description') border-red-500 @enderror" placeholder="Descrição da Tarefa" rows="5" required></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 49%;">
                <label for="duration" class="text-sm mb-1">Duração</label>
                <select 
                    name="duration" 
                    id="duration" 
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('duration') border-red-500 @enderror" 
                    required
                >
                    <option value="" disabled selected>Selecione a Duração</option>
                    <option value="half hour">30 Minutos</option>
                    <option value="hour">1 Hora</option>
                    <option value="turn">1 Turno</option>
                </select>
                @error('duration')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: inline-block; width: 49%; margin-left: 2%;">
                <label for="status" class="text-sm mb-1">Status</label>
                <select 
                    name="status" 
                    id="status" 
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('status') border-red-500 @enderror" 
                    required
                >
                    <option value="" disabled selected>Selecione o Status</option>
                    <option value="finished">Concluida</option>
                    <option value="ongoing">Em Progresso</option>
                    <option value="delayed">Atrasada</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <label for="category_id" class="text-sm mb-1">Categoria (Opcional)</label>
                <select 
                    name="category_id" 
                    id="category_id" 
                    class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('category_id') border-red-500 @enderror"
                >
                    <option value="" disabled selected>Selecione a Categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('task.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Cadastrar</button>
        </div>
    </form>
</div>

@endsection
