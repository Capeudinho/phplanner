@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/form.css">
@endpush

@section('content')
<div class="container-custom">
    <h1 class="text-2xl font-normal mb-6">Gerar Relatório</h1>

    <form method="POST" action="{{ route('report.generate') }}">
        @csrf

        <div class="flex mb-6">
            <div style="display: inline-block; width: 24%;">
                <label for="start_date" class="text-sm mb-1">Data Inicial:</label>
                <input type="date" name="start_date" id="start_date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md @error('start_date') border-red-500 @enderror"
                    @if(isset($start_date)) value="{{ $start_date }}" @else value="{{ old('start_date') }}" @endif>
                @error('start_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: inline-block; width: 24%; margin-left: 2%;">
                <label for="end_date" class="text-sm mb-1">Data Final:</label>
                <input type="date" name="end_date" id="end_date" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md @error('end_date') border-red-500 @enderror"
                    @if(isset($end_date)) value="{{ $end_date }}" @else value="{{ old('end_date') }}" @endif>
                @error('end_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: inline-block; width: 48%; margin-left: 2%;">
                <label for="type" class="text-sm mb-1">Relatório:</label>
                <select name="type" id="type" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md @error('type') border-red-500 @enderror">
                    <option value="" disabled selected hidden>Selecione um Relatório</option>
                    <option value="1" @if(isset($type) && $type == 1) selected @endif>Categorias de metas mais realizadas</option>
                    <option value="2" @if(isset($type) && $type == 2) selected @endif>Categorias de tarefas mais realizadas</option>
                    <option value="3" @if(isset($type) && $type == 3) selected @endif>Destacar turnos mais produtivos</option>
                    <option value="4" @if(isset($type) && $type == 4) selected @endif>Quant. e Porcentagem de metas cumpridas</option>
                    <option value="5" @if(isset($type) && $type == 5) selected @endif>Quant. e Porcentagem de tarefas executadas</option>
                    <option value="6" @if(isset($type) && $type == 6) selected @endif>Destacar semanas e meses mais produtivos</option>
                </select>
                @error('type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="add-button">Gerar</button>
        </div>
    </form>
</div>
@endsection
