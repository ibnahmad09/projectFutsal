@extends('layouts.user')

@section('title', 'Lapangan')

@section('content')



<div class="pt-20 pb-12 bg-green-700">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Daftar Lapangan</h1>
            <p class="text-lg">Pilih lapangan favoritmu dan mulai booking!</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block mb-2 font-medium">Cari Lapangan</label>
                <input type="text" placeholder="Cari nama lapangan..."
                       class="w-full p-2 border rounded-lg">
            </div>
            <div>
                <label class="block mb-2 font-medium">Tipe Lapangan</label>
                <select class="w-full p-2 border rounded-lg">
                    <option>Semua Tipe</option>
                    <option>Indoor</option>
                    <option>Outdoor</option>
                </select>
            </div>
            <div>
                <label class="block mb-2 font-medium">Urutkan</label>
                <select class="w-full p-2 border rounded-lg">
                    <option>Terbaru</option>
                    <option>Harga Tertinggi</option>
                    <option>Harga Terendah</option>
                    <option>Rating Tertinggi</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Lapangan Grid -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Lapangan Card 1 -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
            <div class="relative">
                <img src="https://source.unsplash.com/random/800x600?futsal1"
                     alt="Lapangan 1"
                     class="h-48 w-full object-cover">
                <span class="absolute top-2 right-2 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                    Indoor
                </span>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold">Lapangan Utama</h3>
                    <div class="flex items-center">
                        <i class='bx bx-star text-yellow-400 mr-1'></i>
                        <span>4.8</span>
                    </div>
                </div>

                <!-- Fasilitas -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-2 py-1 bg-gray-100 rounded-full text-sm flex items-center">
                        <i class='bx bx-wifi text-gray-600 mr-1'></i>WiFi
                    </span>
                    <span class="px-2 py-1 bg-gray-100 rounded-full text-sm flex items-center">
                        <i class='bx bx-car text-gray-600 mr-1'></i>Parkir
                    </span>
                    <span class="px-2 py-1 bg-gray-100 rounded-full text-sm flex items-center">
                        <i class='bx bx-shower text-gray-600 mr-1'></i>Shower
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-2xl font-bold text-green-600">Rp120.000</span>
                        <span class="text-gray-600">/jam</span>
                    </div>
                    <a href="{{ url('/lapangan-detail') }}"
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
                        <i class='bx bx-info-circle mr-2'></i>Detail
                    </a>
                </div>
            </div>
        </div>

        <!-- Tambahkan lebih banyak card lapangan -->
    </div>
</div>

<!-- Pagination -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-center gap-2">
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg">1</button>
        <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">2</button>
        <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">3</button>
        <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">...</button>
    </div>
</div>


@endsection
