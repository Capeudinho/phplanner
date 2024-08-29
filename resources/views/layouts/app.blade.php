<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Quicksand:wght@100;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
     
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>

<body class="font-sans antialiased " style="background:#E4EBED" >
    <div class="flex flex-col min-h-screen">
        @include('layouts.components.navbar')
        <div class="flex flex-1">
            @if(Auth::check())
                @include('layouts.components.sidebar') 
            @endif
            <div class="flex-1 p-6">
            @if(session('success'))
            <div class="alert alert-success" id="successAlert">
                {{ session('success') }}
            </div>
            @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = 0; 
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 600); 
            }, 3000); 
        }
    </script>
    @stack('scripts')

</body>
</html>
