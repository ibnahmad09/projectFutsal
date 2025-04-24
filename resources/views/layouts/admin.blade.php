<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FUTSALDESA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .cyber-glow {
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }
        .hologram-effect {
            background: linear-gradient(145deg,
                rgba(16, 185, 129, 0.1) 0%,
                rgba(34, 197, 94, 0.05) 50%,
                rgba(16, 185, 129, 0.1) 100%);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        .neon-text {
            text-shadow: 0 0 10px rgba(16, 185, 129, 0.7);
        }
        .cyber-table {
            background: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .field-card {
            background: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }
        .field-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.2);
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Admin Navigation -->
 <div class="flex h-screen overflow-hidden">
    <!-- Cyber Sidebar -->
    <aside class="hidden md:block w-64 bg-gray-800 hologram-effect flex flex-col border-r border-green-900">
        <div class="p-6 border-b border-green-900">
            <h2 class="text-2xl font-bold text-green-400 neon-text">FUTSAL<span class="text-white">ADMIN</span></h2>
        </div>

        <nav class="flex-1 p-4 space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition cyber-glow">
                <i class='bx bx-dashboard text-green-400 mr-2'></i>
                Dashboard
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-calendar-check text-green-400 mr-2'></i>
                Bookings
            </a>
            <a href="{{ route('admin.fields.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-football text-green-400 mr-2'></i>
                Fields
            </a>
            <a href="{{ route('admin.analytics') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-line-chart text-green-400 mr-2'></i>
                Analytics
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-user text-green-400 mr-2'></i>
                Users
            </a>
            <a href="{{ route('admin.reports.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                <i class='bx bx-file text-green-400 mr-2'></i>
                Report
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Cyber Header -->
        <header class="hologram-effect p-4 flex justify-between items-center border-b border-green-900">
            <div class="flex items-center space-x-4">
                <!-- Tombol Toggle Sidebar untuk Mobile -->
                <button class="md:hidden text-white" onclick="toggleSidebar()">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
                <div class="relative">
                    <div class="w-3 h-3 bg-green-400 rounded-full absolute -right-0 -top-0 cyber-glow"></div>
                    <div class="w-10 h-10 bg-green-400 rounded-full flex items-center justify-center">
                        <i class='bx bx-shield-alt-2 text-xl'></i>
                    </div>
                </div>
                <div>
                    <h1 class="font-bold">Admin Dashboard</h1>
                    <p class="text-xs text-green-400">Real-time Monitoring System</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="p-2 hover:bg-gray-800 rounded-lg relative">
                    <i class='bx bx-bell text-xl'></i>
                    <div class="w-2 h-2 bg-red-500 rounded-full absolute top-1 right-1"></div>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 hover:bg-gray-800 rounded-lg">
                        <i class='bx bx-log-out text-xl'></i>
                    </button>
                </form>
            </div>
        </header>

    @yield('content')


</body>
</html>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('aside');
        sidebar.classList.toggle('hidden');
    }
</script>
