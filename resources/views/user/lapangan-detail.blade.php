@extends('layouts.user')

@section('title', 'Lapangan')

@section('content')

<!-- Header Section -->
 <div class="pt-20 pb-12 bg-green-700">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-2">Lapangan Utama</h1>
            <div class="flex items-center justify-center gap-2">
                <i class='bx bx-star text-yellow-400'></i>
                <span>4.8 (120 reviews)</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Gallery -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <img src="https://source.unsplash.com/random/1200x800?futsal-main"
                         class="w-full h-96 object-cover rounded-xl">
                </div>
                <div class="col-span-1">
                    <img src="https://source.unsplash.com/random/800x600?futsal2"
                         class="w-full h-48 object-cover rounded-xl">
                </div>
                <div class="col-span-1">
                    <img src="https://source.unsplash.com/random/800x600?futsal3"
                         class="w-full h-48 object-cover rounded-xl">
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="bg-white p-6 rounded-xl shadow-md h-fit sticky top-8">
            <h2 class="text-2xl font-bold mb-4">Booking Sekarang</h2>

            <div class="space-y-4">
                <div>
                    <label class="block mb-2 font-medium">Tanggal</label>
                    <input type="date" class="w-full p-2 border rounded-lg">
                </div>

                <div>
                    <label class="block mb-2 font-medium">Waktu</label>
                    <select class="w-full p-2 border rounded-lg">
                        <option>08:00 - 09:00</option>
                        <option>09:00 - 10:00</option>
                        <!-- Tambahkan slot waktu -->
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Durasi</label>
                    <select class="w-full p-2 border rounded-lg">
                        <option>1 Jam</option>
                        <option>2 Jam</option>
                        <option>3 Jam</option>
                    </select>
                </div>

                <hr class="my-4">

                <div class="flex justify-between text-xl font-bold">
                    <span>Total:</span>
                    <span>Rp240.000</span>
                </div>

                <button class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition">
                    Lanjutkan ke Pembayaran
                </button>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
        <!-- Fasilitas -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-2xl font-bold mb-4">Fasilitas</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center">
                    <i class='bx bx-wifi text-green-600 mr-2'></i>
                    WiFi Gratis
                </div>
                <div class="flex items-center">
                    <i class='bx bx-car text-green-600 mr-2'></i>
                    Parkir Luas
                </div>
                <!-- Tambahkan fasilitas lain -->
            </div>
        </div>

        <!-- Ulasan -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-2xl font-bold mb-4">Ulasan (120)</h3>

            <!-- Review Item -->
            <div class="border-b pb-4 mb-4">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-gray-200 rounded-full"></div>
                    <div>
                        <h4 class="font-bold">John Doe</h4>
                        <div class="flex items-center text-yellow-400">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star-half'></i>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">Lapangan sangat nyaman dengan rumput sintetis berkualitas tinggi...</p>
            </div>

            <!-- Tambahkan lebih banyak ulasan -->
        </div>
    </div>
</div>

@endsection
