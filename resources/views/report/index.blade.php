<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{Auth::user()->name}}, bem vindo a sua página de relatórios!
                </div>
                <div class="container" style="margin-top: 10px">
                    @include('report.search')
                </div>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>