<div id="sidebar" class="shadow-lg border-gray-200 p-4 hidden transition-opacity opacity-0" style="background: var(--Container, #F2F6F7); width: 250px;">
    <ul class="space-y-6">

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/home.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Início</span>
            </a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('task.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/task.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Tarefas</span>
            </a>
        </li>
        
        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('goal.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/goal.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Metas</span>
            </a>
        </li>

        <li class="hover:bg-gray-200 rounded-lg flex items-center p-2">
            <a href="{{ route('report.index') }}" class="text-gray-700 hover:text-gray-900 block w-full flex items-center">
                <img src="{{ asset('icons/report.svg') }}" alt="Dashboard Icon" class="h-5 w-5">
                <span class="ml-2">Relatórios</span>
            </a>
        </li>
    </ul>
</div>

<script>
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.getElementById('sidebar');
    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        setTimeout(() => {
            sidebar.classList.toggle('opacity-0');
        }, 20);
    });
</script>
