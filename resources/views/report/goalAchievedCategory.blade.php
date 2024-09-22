<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{Auth::user()->name}}, bem vindo a sua página de relatórios!
                </div>
                <div class="container" style="margin-top: 10px">
                    <hr>

                    @foreach(array_reverse($categories) as $category)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg meta" id="{{$category->name}}">
                            @if($category->name == 'Saúde')
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @elseif($category->name == 'Esporte')
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @elseif($category->name == 'Lazer')
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @elseif($category->name == 'Estudo')
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @elseif($category->name == 'Trabalho')
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @elseif($category->name == 'Reuniões')
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @else
                                <div class="p-6 border-b border-gray-200" style="background-color: {{$category->color}};">
                            @endif
                            <h5>{{$category->name}} - Quantidade: {{$category->quantity}}</h5>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>