@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Hero Section -->
    <div class="pt-20 pb-12 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Sewa Lapangan Futsal Desa</h1>
                <p class="text-lg mb-8">Booking lapangan favoritmu kapan saja, dimana saja!</p>
                @guest
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-green-600 px-6 py-2 rounded-lg hover:bg-green-50 transition">
                        Daftar
                    </a>
                </div>
                @endguest
            </div>
        </div>
    </div>

    <!-- Lapangan Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center">Lapangan Tersedia</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($fields as $field)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-[1.02] transition-transform">
                <div class="relative h-48">
                    <img src="{{ $field->images->first() ? asset('storage/' . $field->images->first()->image_path) : 'https://source.unsplash.com/random/800x600?futsal' }}" 
                         alt="{{ $field->name }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute top-2 right-2 bg-white/80 backdrop-blur-sm px-2 py-1 rounded-full text-xs">
                        {{ $field->is_available ? '🟢 Tersedia' : '🔴 Penuh' }}
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold mb-2">{{ $field->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $field->description }}</p>
                    <a href="{{ route('user.lapangan.show', $field) }}" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                        <i class='bx bx-info-circle mr-2'></i>Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
