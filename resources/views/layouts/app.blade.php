<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">



        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}">
        <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-kominfo.png') }}" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
    </head>
    <body class=" bg-gray-100">
        <x-banner />
        <div class="min-h-screen">
            @livewire('navigation-menu')
            <!-- Page Heading -->
            {{--
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            --}}
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('modals')
        @livewireScripts
    </body>
</html>
