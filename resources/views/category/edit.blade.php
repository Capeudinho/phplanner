@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-normal mb-6">Editar Categoria</h1>

        <form id="Form" action="{{ route('category.update', ['category' => $category->id]) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-6">
                <div class="mb-4">
                    <label for="name" class="text-sm mb-1 block">Nome da Categoria</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror"
                        value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="color" class="text-sm mb-1 block">Cor</label>
                    <select name="color" id="color"
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-md w-full @error('color') border-red-500 @enderror"
                        required>
                        <option value="" disabled>Selecione a Cor</option>
                        <option value="#CC0000" style="color:#CC0000;" {{ $category->color == '#CC0000' ? 'selected' : '' }}>Vermelho</option>
                        <option value="#CC6600" style="color:#CC6600;" {{ $category->color == '#CC6600' ? 'selected' : '' }}>Laranja</option>
                        <option value="#CCCC00" style="color:#CCCC00;" {{ $category->color == '#CCCC00' ? 'selected' : '' }}>Amarelo</option>
                        <option value="#66CC00" style="color:#66CC00;" {{ $category->color == '#66CC00' ? 'selected' : '' }}>Lima</option>
                        <option value="#00CC00" style="color:#00CC00;" {{ $category->color == '#00CC00' ? 'selected' : '' }}>Verde</option>
                        <option value="#00CC66" style="color:#00CC66;" {{ $category->color == '#00CC66' ? 'selected' : '' }}>Menta</option>
                        <option value="#00CCCC" style="color:#00CCCC;" {{ $category->color == '#00CCCC' ? 'selected' : '' }}>Ciano</option>
                        <option value="#0066CC" style="color:#0066CC;" {{ $category->color == '#0066CC' ? 'selected' : '' }}>Azul 1</option>
                        <option value="#0000CC" style="color:#0000CC;" {{ $category->color == '#0000CC' ? 'selected' : '' }}>Azul</option>
                        <option value="#6600CC" style="color:#6600CC;" {{ $category->color == '#6600CC' ? 'selected' : '' }}>Roxo</option>
                        <option value="#CC00CC" style="color:#CC00CC;" {{ $category->color == '#CC00CC' ? 'selected' : '' }}>Magenta</option>
                        <option value="#CC0066" style="color:#CC0066;" {{ $category->color == '#CC0066' ? 'selected' : '' }}>Rosa</option>
                    </select>
                    </select>
                    @error('color')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('category.index') }}" class="cancel-button">Cancelar</a>
                <button type="submit" class="add-button">Editar</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('color').addEventListener('change', function() {
            var selectedColor = this.value;
            this.style.color = selectedColor;
        });

        document.getElementById('color').style.color = "{{ $category->color }}";
    </script>
@endsection
