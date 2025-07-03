<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
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
        #loader-wrapper {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rolling-ball {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle at 20px 20px, #4caf50 70%, #388e3c 100%);
            position: relative;
            animation: roll 1.2s cubic-bezier(.68,-0.55,.27,1.55) infinite;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        @keyframes roll {
            0% {
                transform: translateX(0) rotate(0deg);
                box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            }
            50% {
                transform: translateX(120px) rotate(360deg);
                box-shadow: 0 16px 32px rgba(0,0,0,0.10);
            }
            100% {
                transform: translateX(0) rotate(720deg);
                box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            }
        }
    </style>
    @laravelPWA
</head>
<body class="bg-gray-50">
    <!-- Loader Start -->
    <div id="loader-wrapper">
        <div class="rolling-ball"></div>
    </div>
    <!-- Loader End -->

    <!-- Navbar -->
    <nav class="bg-green-700 shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{route('user.home.index')}}" class="flex items-center gap-2">
                    <i class='bx bx-football text-green-300 text-2xl md:text-3xl'></i>
                    <span class="text-base md:text-xl font-bold whitespace-nowrap">FUTSALDESA<span class="text-green-300 ml-1">BUKITKEMUNING</span></span>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{route('user.lapangan.index')}}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Lapangan</a>
                    <a href="{{ route('user.abouts.index') }}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Tentang</a>
                    <a href="{{route('user.profil.show')}}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Profil</a>
                    <a href="{{ route('user.bookings.index') }}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Riwayat Booking</a>
                    <a href="{{ route('user.member') }}" class="text-white hover:bg-green-600/50 p-2 rounded-lg">Member</a>
                    @if (Auth::check())
                        @if(auth()->user()->member && auth()->user()->member->is_active)
                            <span class="bg-green-600 text-white px-2 py-0.5 text-xs md:text-sm rounded-full hidden md:inline-block">Member</span>
                        @else
                            <span class="bg-gray-600 text-white px-2 py-0.5 text-xs md:text-sm rounded-full md:inline-block">Non-Member</span>
                        @endif
                    @endif
                </div>

                <!-- Tombol Login/Logout & Menu -->
                <div class="flex items-center space-x-4">
                    @if (Auth::check())
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

                    <button class="text-white md:hidden" id="mobile-menu-button" onclick="toggleMobileMenu()">
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
                    @if (Auth::check())
                        @if(auth()->user()->member && auth()->user()->member->is_active)
                            <span class="bg-green-600 text-white px-2 py-0.5 text-xs md:text-sm rounded-full mt-2 text-center">Member</span>
                        @else
                            <span class="bg-gray-600 text-white px-2 py-0.5 text-xs md:text-sm rounded-full mt-2 text-center">Non-Member</span>
                        @endif
                    @endif
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
                    <h4 class="text-xl font-bold mb-4">FUTSALDESABUKITKEMUNING</h4>
                    <p class="text-gray-400">Sistem penyewaan lapangan futsal terintegrasi untuk desa</p>
                </div>
                <div>
                    <h4 class="text-xl font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class='bx bx-phone mr-2'></i>+62 822-9937-1851</li>
                        <li><i class='bx bx-envelope mr-2'></i>sucipuspitasari3000@gmail.com</li>
                    </ul>
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

        window.addEventListener('load', function() {
            document.getElementById('loader-wrapper').style.display = 'none';
        });
    </script>
</body>
</html>
