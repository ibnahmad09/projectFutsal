<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FUTSALDESA</title>
    @vite('resources/css/app.css')
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

        /* Mobile Sidebar Styles */
        .mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-sidebar.active {
            transform: translateX(0);
        }

        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-in-out;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }

        @media (min-width: 768px) {
            #sidebar {
                transform: none !important;
                position: relative !important;
                left: 0 !important;
            }
            .sidebar-overlay {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" onclick="closeSidebar()"></div>

    <!-- Admin Navigation -->
    <div class="flex h-screen overflow-hidden">
        <!-- Cyber Sidebar -->
        <aside id="sidebar" class="mobile-sidebar md:translate-x-0 fixed md:relative inset-y-0 left-0 z-50 w-64 bg-gray-800 hologram-effect flex flex-col border-r border-green-900">
            <div class="p-6 border-b border-green-900">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-green-400 neon-text">FUTSAL<span class="text-white">ADMIN</span></h2>
                    <!-- Close button for mobile -->
                    <button class="md:hidden text-white hover:text-green-400" onclick="closeSidebar()">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition cyber-glow" onclick="closeSidebar()">
                    <i class='bx bx-dashboard text-green-400 mr-2'></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition" onclick="closeSidebar()">
                    <i class='bx bx-calendar-check text-green-400 mr-2'></i>
                    Booking
                </a>
                <a href="{{ route('members.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition" onclick="closeSidebar()">
                    <i class='bx bx-member text-green-400 mr-2'></i>
                    Member
                </a>
                <a href="{{ route('admin.fields.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition" onclick="closeSidebar()">
                    <i class='bx bx-football text-green-400 mr-2'></i>
                    lapangan
                </a>
                <a href="{{ route('admin.analytics') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition" onclick="closeSidebar()">
                    <i class='bx bx-line-chart text-green-400 mr-2'></i>
                    Analitik
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition" onclick="closeSidebar()">
                    <i class='bx bx-user text-green-400 mr-2'></i>
                    User
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition" onclick="closeSidebar()">
                    <i class='bx bx-file text-green-400 mr-2'></i>
                    Laporan
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Cyber Header -->
            <header class="hologram-effect p-4 flex justify-between items-center border-b border-green-900">
                <div class="flex items-center space-x-4">
                    <!-- Tombol Toggle Sidebar untuk Mobile -->
                    <button class="md:hidden text-white hover:text-green-400" onclick="toggleSidebar()">
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

            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        body.classList.toggle('sidebar-open');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        body.classList.remove('sidebar-open');
    }

    // Close sidebar when clicking on a link (for mobile)
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('aside nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) { // Mobile breakpoint
                    closeSidebar();
                }
            });
        });
    });

    // Close sidebar on window resize if switching to desktop
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const body = document.body;

        if (window.innerWidth >= 768) {
            // Pastikan sidebar selalu tampil di desktop
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            body.classList.remove('sidebar-open');
        }
    });

    async function validateDuration() {
        const fieldId = document.querySelector('select[name="field_id"]').value;
        const date = document.querySelector('input[name="booking_date"]').value;
        const startTime = document.getElementById('start_time').value;
        const duration = parseInt(document.getElementById('duration').value);

        if (!fieldId || !date || !startTime || !duration) return;

        try {
            const response = await fetch(`/api/available-times/${fieldId}?date=${date}`);
            const data = await response.json();

            // Hitung waktu selesai
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(start.getTime() + duration * 60 * 60 * 1000);
            const endTime = end.toTimeString().slice(0, 5);

            // Buat array dari semua slot yang dibutuhkan
            const requiredSlots = [];
            let currentTime = new Date(start);

            for (let i = 0; i < duration; i++) {
                requiredSlots.push(currentTime.toTimeString().slice(0, 5));
                currentTime.setHours(currentTime.getHours() + 1);
            }

            // Cek apakah semua slot yang dibutuhkan tersedia
            const allSlotsAvailable = requiredSlots.every(slot =>
                data.available_slots.includes(slot)
            );

            if (!allSlotsAvailable) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Durasi Tidak Tersedia',
                    text: 'Beberapa slot waktu dalam durasi yang dipilih sudah dipesan. Silakan pilih durasi yang lebih pendek atau waktu mulai yang berbeda.'
                });
                document.getElementById('duration').value = '1';
            }
        } catch (error) {
            console.error('Error validating duration:', error);
        }
    }
</script>

@stack('scripts')
</body>
</html>
