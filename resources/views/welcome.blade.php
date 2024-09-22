@extends('layouts.app')



@section('content')
<div class="flex items-center justify-center"> 

    <div class="mb-8">
        <img src="{{ asset('images/teste.svg') }}" alt="Phplanner Image" class="w-full max-w-md">
    </div>

    <p class="text-lg text-gray-600 text-center max-w-xl">
        Bem-vindo ao <span class="font-bold">Phplanner</span>, o sistema que ajuda você a organizar suas tarefas, planejar suas metas e otimizar seu tempo.
    </p>
</div>

<footer class="mt-8"> 
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center">
        <p class="text-gray-600">© 2024 Phplanner. Todos os direitos reservados.</p>
    </div>
</footer>
@endsection
