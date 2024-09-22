<nav style="background: var(--Container, #F2F6F7); border-bottom: 1px solid var(--Outlines, #BCC9CE); position: relative;">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        @if(Auth::check())
        <div class="flex justify-between h-16 items-center">
            <div class="hover:bg-gray-200 flex items-center rounded-lg">
                <button id="menu-button" class="focus:outline-none">
                    <img src="{{ asset('icons/sidemenu.svg') }}" alt="Menu Icon" class="h-4 w-4">
                </button>
            </div>

            <div class="relative flex items-center space-x-4">
                <div class="hover:bg-gray-200 flex items-center p-1 rounded-lg">
                    <button id="profile-button" class="focus:outline-none flex items-center">
                        <img src="{{ asset('icons/profile.svg') }}" alt="Profile Icon" class="h-5 w-5">
                        <img src="{{ asset('icons/downarrow.svg') }}" alt="Down Arrow Icon" class="h-3 w-3 ml-2">
                    </button>
                </div>
                
                <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Sair</button>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="flex justify-end h-16 items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="button">Login</a>
                <a href="{{ route('register') }}" class="button">Cadastro</a>
            </div>
        </div>
        @endif
    </div>

    <script>
        document.getElementById('profile-button').addEventListener('click', function(event) {
            event.stopPropagation();
            var profileMenu = document.getElementById('profile-menu');
            profileMenu.classList.toggle('show');
        });

        document.addEventListener('click', function(event) {
            var profileMenu = document.getElementById('profile-menu');
            var profileButton = document.getElementById('profile-button');
            if (!event.target.closest('#profile-menu') && !event.target.closest('#profile-button')) {
                profileMenu.classList.remove('show');
            }
        });
    </script>
</nav>

<style>
    #profile-menu {
        display: none;
        top: 100%; 
    }

    #profile-menu.show {
        display: block;
    }

    button:focus {
        outline: none;
    }

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
