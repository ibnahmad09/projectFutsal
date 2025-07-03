<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    @laravelPWA
</head>
<body class="bg-gradient-to-r from-green-50 to-green-100">
    <div id="app">
        <!-- Simplified Navbar -->
        <nav class="bg-white shadow-sm" x-data="{ isOpen: false }">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800 flex items-center">
                            <i class='bx bx-football text-green-600 text-2xl mr-2'></i>
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': isOpen, 'inline-flex': !isOpen}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !isOpen, 'inline-flex': isOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden" x-show="isOpen" @click.away="isOpen = false">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    @guest
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center">
                            <i class='bx bx-log-in mr-2'></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center">
                            <i class='bx bx-user-plus mr-2'></i>Register
                        </a>
                    @else
                        <div class="px-3 py-2">
                            <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="mt-1">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="block text-sm text-gray-600 hover:text-gray-800 flex items-center">
                                    <i class='bx bx-log-out mr-2'></i>Logout
                                </a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
