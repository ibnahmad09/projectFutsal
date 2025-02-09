@extends('layouts.admin')

@section('title', 'Admin Cyber Dashboard - FUTSALDESA')

@section('content')


<div class="flex h-screen overflow-hidden">
    <!-- Cyber Sidebar -->
    <aside class="w-64 bg-gray-800 hologram-effect flex flex-col">
        <div class="p-6 border-b border-green-900">
            <h2 class="text-2xl font-bold text-green-400">CYBER<span class="text-white">ADMIN</span></h2>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition cyber-glow">
                <i class='bx bx-pulse mr-2 text-green-400'></i>
                Live Dashboard
            </a>
            <a class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-calendar-alt mr-2'></i>
                Quantum Bookings
            </a>
            <a class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-stats mr-2'></i>
                Neural Analytics
            </a>
            <a class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-shield-alt-2 mr-2'></i>
                Security Matrix
            </a>
        </nav>

        <div class="p-4 border-t border-green-900">
            <div class="text-xs text-gray-400">v2.4.1 CYBERCORE</div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Cyber Header -->
        <header class="hologram-effect p-4 flex justify-between items-center border-b border-green-900">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="w-3 h-3 bg-green-400 rounded-full absolute -right-0 -top-0 cyber-glow"></div>
                    <img src="https://source.unsplash.com/random/100x100?cyber"
                         class="w-10 h-10 rounded-full border-2 border-green-400">
                </div>
                <div>
                    <h1 class="font-bold">Admin Quantum</h1>
                    <p class="text-xs text-green-400">Access Level: 5</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 hover:bg-gray-800 rounded-lg relative">
                    <i class='bx bx-bell text-xl'></i>
                    <div class="w-2 h-2 bg-red-500 rounded-full absolute top-1 right-1"></div>
                </button>
                <button class="p-2 hover:bg-gray-800 rounded-lg">
                    <i class='bx bx-log-out text-xl'></i>
                </button>
            </div>
        </header>

        <!-- Cyber Dashboard -->
        <main class="p-6 space-y-8">
            <!-- Real-Time Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="hologram-effect p-4 rounded-xl">
                    <div class="flex justify-between">
                        <div>
                            <div class="text-2xl font-bold">₿2.4K</div>
                            <div class="text-sm text-green-400">Today's Revenue</div>
                        </div>
                        <i class='bx bx-line-chart text-3xl text-green-400'></i>
                    </div>
                    <div class="mt-2 h-1 bg-gray-700">
                        <div class="h-full bg-green-400 w-3/4"></div>
                    </div>
                </div>

                <!-- Tambahkan 3 statistik lainnya -->
            </div>

            <!-- Holographic Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Live Activity Feed -->
                <div class="lg:col-span-2 hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-radar mr-2 text-green-400'></i>
                        Live Activity Stream
                    </h3>
                    <div class="space-y-4 h-64 overflow-auto">
                        <div class="flex items-center p-3 bg-gray-800 rounded-lg">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                            <span class="text-sm">User#0234 booked Lapangan 1</span>
                            <span class="text-xs text-gray-400 ml-auto">2s ago</span>
                        </div>
                        <!-- Aktivitas lainnya -->
                    </div>
                </div>

                <!-- Quantum Actions -->
                <div class="hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-atom mr-2 text-green-400'></i>
                        Quantum Actions
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="p-4 bg-gray-800 rounded-lg hover:bg-green-400 transition">
                            <i class='bx bx-bolt text-2xl'></i>
                            <span class="block mt-2 text-sm">Quick Edit</span>
                        </button>
                        <!-- Tambahkan action lainnya -->
                    </div>
                </div>
            </div>

            <!-- Neural Network Map -->
            <div class="hologram-effect p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class='bx bx-network-chart mr-2 text-green-400'></i>
                    Booking Neural Network
                </h3>
                <div class="h-64 bg-gray-800 rounded-lg flex items-center justify-center">
                    <div class="text-gray-400">3D Network Visualization</div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Cyber Modal -->
<div class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden" id="cyberModal">
    <div class="bg-gray-800 rounded-xl w-full max-w-2xl p-6 hologram-effect">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Quantum Control Panel</h3>
            <button onclick="closeCyberModal()">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        <!-- Konten Modal -->
    </div>
</div>

<script>
    // Cybernetic Animations
    const cyberElements = document.querySelectorAll('.hologram-effect');
    cyberElements.forEach(el => {
        el.addEventListener('mousemove', (e) => {
            const rect = el.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            el.style.background = `linear-gradient(
                ${x}deg,
                rgba(16, 185, 129, 0.1) 0%,
                rgba(34, 197, 94, 0.05) 50%,
                rgba(16, 185, 129, 0.1) 100%
            )`;
        });
    });

    // Live Data Stream Simulation
    setInterval(() => {
        const activityStream = document.querySelector('.overflow-auto');
        const newActivity = document.createElement('div');
        newActivity.className = 'flex items-center p-3 bg-gray-800 rounded-lg';
        newActivity.innerHTML = `
            <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
            <span class="text-sm">New booking from User#${Math.floor(Math.random()*1000)}</span>
            <span class="text-xs text-gray-400 ml-auto">now</span>
        `;
        activityStream.prepend(newActivity);
    }, 5000);
</script>


@endsection
