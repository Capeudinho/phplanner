@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">
    <h1 class="text-2xl font-normal mb-6">Editar Meta</h1>

    <form id="Form" action="{{ route('goal.update', $goal->id) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <label for="title" class="text-sm mb-1">Título da Meta</label>
                <input type="text" name="title" id="title" value="{{ old('title', $goal->event->title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('title') border-red-500 @enderror" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex mb-6">
            <div style="display: inline-block; width: 100%;">
                <label for="description" class="text-sm mb-1">Descrição da Meta</label>
                <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-md @error('description') border-red-500 @enderror" placeholder="Descrição da Meta" rows="5" required>{{ old('description', $goal->event->description) }}</textarea>
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
                    <option value="" disabled>Selecione a Duração</option>
                    <option value="week" {{ (old('duration', $goal->duration) == 'week') ? 'selected' : '' }}>Semana</option>
                    <option value="month" {{ (old('duration', $goal->duration) == 'month') ? 'selected' : '' }}>Mês</option>
                    <option value="year" {{ (old('duration', $goal->duration) == 'year') ? 'selected' : '' }}>Ano</option>
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
                    <option value="" disabled>Selecione o Status</option>
                    <option value="succeeded" {{ (old('status', $goal->status) == 'succeeded') ? 'selected' : '' }}>Atingida</option>
                    <option value="partially succeeded" {{ (old('status', $goal->status) == 'partially succeeded') ? 'selected' : '' }}>Parcialmente Atingida</option>
                    <option value="failed" {{ (old('status', $goal->status) == 'failed') ? 'selected' : '' }}>Não Atingida</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('goal.index') }}" class="cancel-button">Cancelar</a>
            <button type="submit" class="add-button">Atualizar</button>
        </div>
    </form>
</div>
@endsection
