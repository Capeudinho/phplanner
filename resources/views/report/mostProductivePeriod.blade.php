<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{Auth::user()->name}}, bem vindo a sua página de relatórios!
                </div>
                <div class="container" style="margin-top: 10px">
                    <hr>
                    @foreach($years as $year)
                        @php
                            $aux = 0;
                        @endphp
                        @foreach($year->months as $month)
                            @php
                                if($month->weeks != null){
                                    $aux = 1;
                                }
                            @endphp
                        @endforeach
                        @if($aux > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200" style="background-color: #89CFF0;">

                                <h4><b>Ano de {{$year->year}}<b><h4>
                            @foreach($year->months as $month)
                                <div style="margin-left: 15px; margin-top: 15px;">
                                    @if($month->weeks != null)
                                    <h5>Mês {{$month->month}}<h5>
                                    @endif

                                    @foreach($month->weeks as $week)
                                        <div style="margin-left: 15px;">
                                            <h6><li>Há {{$week->quantity}} tarefas concluidas na semana {{$week->week}}</li><h6>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            </div>
                        </div><br>
                        @endif
                    @endforeach
                </div>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>