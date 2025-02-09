<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan ikon -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-green-700 shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="#" class="flex items-center">
                    <span class="text-white text-2xl font-bold">FUTSAL<span class="text-green-300">DESA</span></span>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ url('/lapangan') }}" class="text-white hover:text-green-200">Lapangan</a>
                    <a href="{{ url('/tentang') }}" class="text-white hover:text-green-200">Tentang</a>
                    <a href="{{ url('/profil')}}" class="text-white hover:text-green-200">Profil</a>
                    <a href="#jadwal" class="text-white hover:text-green-200">Jadwal Saya</a>
                </div>

                <!-- Tombol Login -->
                <button class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition">
                    Masuk/Daftar
                </button>

                <!-- Hamburger Menu (Mobile) -->
                <button class="md:hidden text-white" id="mobile-menu-button">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="md:hidden" id="mobile-menu" style="display: none;">
            <div class="flex flex-col space-y-2 px-4 py-2">
                <a href="{{ url('/lapangan') }}" class="text-white hover:text-green-200">Lapangan</a>
                <a href="{{ url('/tentang') }}" class="text-white hover:text-green-200">Tentang</a>
                <a href="{{ url('/profil')}}" class="text-white hover:text-green-200">Profil</a>
                <a href="#jadwal" class="text-white hover:text-green-200">Jadwal Saya</a>
            </div>
        </div>

        <script>
            document.getElementById('mobile-menu-button').onclick = function() {
                var menu = document.getElementById('mobile-menu');
                menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
            };
        </script>
    </nav>

    @yield('content')

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
</body>
</html>
