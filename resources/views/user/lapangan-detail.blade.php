@extends('layouts.user')

@section('title', $field->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('user.lapangan.index') }}" class="hover:text-green-600">Lapangan</a></li>
            <li class="text-gray-400">/</li>
            <li class="text-green-600">{{ $field->name }}</li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Images Section -->
        <div class="space-y-6">
            <!-- Main Image -->
            <div class="relative h-[300px] md:h-[400px] rounded-2xl overflow-hidden shadow-lg">
                <img src="{{ $field->images->first() ? asset('storage/' . $field->images->first()->image_path) : 'https://source.unsplash.com/random/800x600?futsal' }}" 
                     alt="{{ $field->name }}" 
                     class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                <div class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                    {{ $field->is_available ? '🟢 Tersedia' : '🔴 Penuh' }}
                </div>
            </div>

            <!-- Thumbnails -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($field->images as $image)
                <div class="h-24 rounded-xl overflow-hidden cursor-pointer group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $field->name }}" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-300">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Details Section -->
        <div class="space-y-6">
            <!-- Header -->
            <div class="space-y-4">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $field->name }}</h1>
                
                <!-- Rating and Reviews -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center bg-green-50 px-3 py-1 rounded-full">
                        <i class='bx bx-star text-yellow-400 mr-1'></i>
                        <span class="font-semibold">{{ $field->rating ?? '4.5' }}</span>
                    </div>
                    <span class="text-gray-600">({{ $field->reviews_count ?? 0 }} review)</span>
                </div>

                <!-- Price -->
                <div class="text-2xl md:text-3xl font-bold text-green-600">
                    Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                </div>
            </div>

            <!-- Booking Button -->
            <button onclick="openBookingModal({{ $field->id }})"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-3 rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                🏀 Booking Sekarang
            </button>

            <!-- Field Details -->
            <div class="grid grid-cols-2 gap-4 bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-50 rounded-lg">
                        <i class='bx bx-map text-green-600'></i>
                    </div>
                    <span class="text-sm md:text-base">{{ $field->location }}</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-50 rounded-lg">
                        <i class='bx bx-time text-green-600'></i>
                    </div>
                    <span class="text-sm md:text-base">{{ date('H:i', strtotime($field->open_time)) }} - {{ date('H:i', strtotime($field->close_time)) }}</span>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-sm">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Deskripsi Lapangan</h2>
                <p class="text-gray-600 leading-relaxed text-sm md:text-base">{{ $field->description }}</p>
            </div>

            <!-- Facilities -->
            @if($field->facilities)
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-sm">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Fasilitas</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(json_decode($field->facilities) as $facility)
                    <div class="flex items-center space-x-2">
                        <div class="p-1.5 bg-green-50 rounded-md">
                            <i class='bx bx-check text-green-600'></i>
                        </div>
                        <span class="text-gray-600 text-sm md:text-base">{{ ucfirst($facility) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Jadwal Hari Ini</h2>
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm p-6">
            @if($todayBookings->isEmpty())
            <div class="text-center text-gray-500 py-4">Tidak ada booking hari ini</div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($todayBookings as $booking)
                <div class="p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-sm md:text-base">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                        <span class="px-2 py-1 text-xs md:text-sm rounded-full 
                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="text-xs md:text-sm text-gray-600">Durasi: {{ $booking->duration }} Jam</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Include Booking Modal -->
@include('user.booking')

@endsection
