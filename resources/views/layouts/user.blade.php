<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Di bagian head -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tambahkan ikon -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #mobile-menu {
            display: none;
            position: absolute;
            width: 100%;
            left: 0;
            top: 4rem; /* Sesuaikan dengan tinggi navbar */
            z-index: 1000;
        }
        .avatar-inisial {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #16a34a; /* Warna hijau */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-green-700 shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{route('user.home.index')}}" class="flex items-center">
                    <span class="text-white text-xl font-bold">FUTSAL<span class="text-green-300">DESA</span></span>
                </a>

                <!-- Tombol Login/Logout & Menu -->
                <div class="flex items-center space-x-4">
                    @if (Auth::check())
                        @if(auth()->user()->member && auth()->user()->member->is_active)
                            <span class="bg-green-600 text-white px-4 py-1.5 rounded-full">Member</span>
                        @else
                            <span class="bg-gray-600 text-white px-4 py-1.5 rounded-full">Non-Member</span>
                        @endif
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-full hover:bg-red-600 transition">
                                <i class='bx bx-log-out'></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-500 text-white px-3 py-1.5 rounded-full hover:bg-green-600 transition">
                            <i class='bx bx-log-in'></i>
                        </a>
                    @endif

                    <button class="text-white" id="mobile-menu-button" onclick="toggleMobileMenu()">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div class="md:hidden bg-green-700/95 backdrop-blur-sm" id="mobile-menu" style="display: none;">
                <div class="flex flex-col space-y-2 px-4 py-2">
                    <a href="{{route('user.lapangan.index')}}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Lapangan</a>
                    <a href="{{ route('user.abouts.index') }}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Tentang</a>
                    <a href="{{route('user.profil.show')}}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Profil</a>
                    <a href="{{ route('user.bookings.index') }}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Riwayat Booking</a>
                    <a href="{{ route('user.member') }}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Member</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-xl font-bold mb-4">FUTSALDESA</h4>
                    <p class="text-gray-400">Sistem penyewaan lapangan futsal terintegrasi untuk desa</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class='bx bx-phone mr-2'></i>+62 812-3456-7890</li>
                        <li><i class='bx bx-envelope mr-2'></i>info@futsaldesa.id</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-green-400">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-green-400">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Sosial Media</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-2xl hover:text-green-400"><i class='bx bxl-instagram'></i></a>
                        <a href="#" class="text-2xl hover:text-green-400"><i class='bx bxl-facebook'></i></a>
                        <a href="#" class="text-2xl hover:text-green-400"><i class='bx bxl-whatsapp'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
                mobileMenu.style.display = 'block';
            } else {
                mobileMenu.style.display = 'none';
            }
        }

        // Tambahkan event listener untuk menutup menu saat mengklik di luar
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');

            if (!button.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
