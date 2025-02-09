
    @extends('layouts.user')

    @section('title','Home')


    @section('content')

    @extends('user.booking')

    <!-- Hero Section -->
    <div class="pt-20 pb-12 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Sewa Lapangan Futsal Desa</h1>
                <p class="text-lg mb-8">Booking lapangan favoritmu kapan saja, dimana saja!</p>

                <!-- Search Form -->
                <div class="max-w-2xl mx-auto bg-white rounded-lg p-4 shadow-lg">
                    <div class="flex flex-col md:flex-row gap-4">
                        <input type="date" class="p-2 border rounded-lg flex-1">
                        <input type="time" class="p-2 border rounded-lg flex-1">
                        <select class="p-2 border rounded-lg flex-1">
                            <option>1 Jam</option>
                            <option>2 Jam</option>
                            <option>3 Jam</option>
                        </select>
                        <button class="bg-green-600 text-white p-2 rounded-lg hover:bg-green-700 transition">
                            Cari Lapangan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Lapangan -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Lapangan Tersedia</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card Lapangan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="https://source.unsplash.com/random/800x600?futsal" alt="Lapangan" class="h-48 w-full object-cover">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold">Lapangan 1</h3>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Tersedia</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class='bx bx-star text-yellow-400 mr-1'></i>
                        <span class="font-semibold">4.8</span>
                        <span class="text-gray-600 ml-2">(120 review)</span>
                    </div>
                    <p class="text-gray-600 mb-4">Lapangan indoor dengan rumput sintetis berkualitas tinggi</p>
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-green-600">Rp120.000/jam</span>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" onclick="openBookingModal()">
                            Booking
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tambahkan lebih banyak card lapangan -->
        </div>
    </div>

    <!-- Cara Booking -->
    <div class="bg-green-50 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Cara Booking</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="bg-green-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class='bx bx-calendar text-white text-2xl'></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Pilih Jadwal</h3>
                    <p class="text-gray-600">Pilih tanggal dan jam yang tersedia</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-green-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class='bx bx-wallet text-white text-2xl'></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Bayar Online</h3>
                    <p class="text-gray-600">Lakukan pembayaran dengan metode pilihanmu</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-green-600 w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class='bx bx-football text-white text-2xl'></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Main!</h3>
                    <p class="text-gray-600">Datang dan nikmati permainanmu</p>
                </div>
            </div>
        </div>
    </div>

@endsection
