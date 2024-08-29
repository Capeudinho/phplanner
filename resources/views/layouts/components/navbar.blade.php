<nav style="background: var(--Container, #F2F6F7); border-bottom: 1px solid var(--Outlines, #BCC9CE);">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        @if(Auth::check())
        <div class="flex justify-between h-16 items-center">
                <div class="hover:bg-gray-200 flex items-center rounded-lg">
                    <button id="menu-button" class="focus:outline-none">
                        <img src="{{ asset('icons/sidemenu.svg') }}" alt="Menu Icon" class="h-4 w-4">
                    </button>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="hover:bg-gray-200 flex items-center p-1 rounded-lg">
                        <button class="focus:outline-none flex items-center">
                            <img src="{{ asset('icons/profile.svg') }}" alt="Profile Icon" class="h-5 w-5">
                            <img src="{{ asset('icons/downarrow.svg') }}" alt="Down Arrow Icon" class="h-3 w-3 ml-2">
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="flex justify-end h-16 items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="button">Login</a>
                    <a href="{{ route('register') }}" class="button">Cadastro</a>
                </div>
            <div>
            @endif
    </div>
</nav>

<style>
    .button {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border: none;
    background-color: #0C469E;
    color: white;
    border-radius: 0.5rem;
    font-size: 1rem;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s, color 0.3s;
}

.button:hover {
    background-color: #0A3A81;
}
</style>
