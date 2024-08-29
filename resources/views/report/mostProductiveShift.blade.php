<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{Auth::user()->name}}, bem vindo a sua página de relatórios!
                </div>
                <div class="container" style="margin-top: 10px">
                    @include('report.search')
                    <hr>
                    @foreach(array_reverse($shifts) as $shift)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" id="{{$shift->shift}}">
                        @if($shif->shif == 'Manha')
                            <div class="p-6 border-b border-gray-200" style="background-color: #89CFF0;">
                        @elseif($shif->shif == 'Tarde')
                            <div class="p-6 border-b border-gray-200" style="background-color: #fdee00;">
                        @else
                            <div class="p-6 border-b border-gray-200" style="background-color: #002D62; color: white;">
                        @endif
                        <h5>{{$shif->shif}} com Quantidade: {{$shif->quantity}}</h5>
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