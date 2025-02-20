@extends('layouts.user')

@section('title', 'Lapangan')

@section('content')
    <!-- Hero Section -->
    <div class="pt-20 pb-12 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Lapangan Futsal</h1>
                <p class="text-lg">Temukan lapangan futsal terbaik untuk pertandingan Anda</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Search and Filter -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="date" class="p-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                    <input type="time" class="p-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                    <select class="p-2 border rounded-lg focus:ring-2 focus:ring-green-500">
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

        <!-- Fields Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($fields as $field)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <!-- Field Image -->
                    <div class="relative h-48">
                        <img src="{{ $field->images->first() ? asset('storage/' . $field->images->first()->image_path) : 'https://source.unsplash.com/random/800x600?futsal' }}"
                            alt="{{ $field->name }}" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4 bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                            {{ $field->is_available ? 'Tersedia' : 'Penuh' }}
                        </div>
                    </div>

                    <!-- Field Info -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold">{{ $field->name }}</h3>
                            <div class="flex items-center">
                                <i class='bx bx-star text-yellow-400 mr-1'></i>
                                <span class="font-semibold">{{ $field->rating ?? '4.5' }}</span>
                            </div>
                        </div>

                        <p class="text-gray-600 mb-4">{{ Str::limit($field->description, 100) }}</p>

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-gray-600">
                                <i class='bx bx-map mr-2'></i>
                                {{ $field->location }}
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class='bx bx-time mr-2'></i>
                                {{ date('H:i', strtotime($field->open_time)) }} -
                                {{ date('H:i', strtotime($field->close_time)) }}
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-green-600">
                                Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                            </span>
                            <a href="{{ route('user.lapangan.show', $field->id) }}"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Booking
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $fields->links() }}
        </div>
    </div>
@endsection
