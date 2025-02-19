@extends('layouts.user')

@section('title', 'Home')


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

    <div class="container mx-auto px-4 py-8">
        <!-- Live Schedule Section -->
        <div class="mb-12 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Jadwal Penyewaan Hari Ini</h2>

            <!-- Timeline Container -->
            <div class="relative overflow-x-auto pb-4">
                <div class="flex space-x-4" id="scheduleTimeline">
                    @foreach ($currentBookings as $booking)
                        <div class="flex-shrink-0 w-64 bg-green-50 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-semibold">{{ $booking->field->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $booking->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-sm">
                                <i class='bx bx-time mr-1'></i>
                                {{ date('H:i', strtotime($booking->start_time)) }} -
                                {{ date('H:i', strtotime($booking->end_time)) }}
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                {{ $booking->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <div class="inline-flex items-center text-green-600">
                    <i class='bx bx-refresh bx-spin mr-2'></i>
                    <span>Update Real-time</span>
                </div>
            </div>
        </div>

        <!-- Existing Fields Grid -->
        <!-- ... (kode sebelumnya tetap sama) ... -->
    </div>
    <script>
        // Fungsi untuk update jadwal real-time
        function updateSchedule() {
            fetch('/api/current-bookings')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('scheduleTimeline');
                    container.innerHTML = '';

                    data.forEach(booking => {
                        const bookingElement = `
                    <div class="flex-shrink-0 w-64 bg-green-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold">${booking.field.name}</h3>
                                <p class="text-sm text-gray-600">${booking.user.name}</p>
                            </div>
                        </div>
                        <div class="text-sm">
                            <i class='bx bx-time mr-1'></i>
                            ${booking.start_time} - ${booking.end_time}
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                            ${booking.status}
                        </span>
                    </div>
                `;
                        container.insertAdjacentHTML('beforeend', bookingElement);
                    });
                });
        }

        // Update setiap 30 detik
        setInterval(updateSchedule, 30000);

        // Pertama kali load
        document.addEventListener('DOMContentLoaded', updateSchedule);
    </script>

    <!-- Daftar Lapangan -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Lapangan Tersedia</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($fields as $field)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                    @if ($field->images && $field->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $field->images->first()->image_path) }}" alt="Lapangan"
                            class="h-48 w-full object-cover">
                    @else
                        <img src="https://source.unsplash.com/random/800x600?futsal" alt="Lapangan"
                            class="h-48 w-full object-cover">
                    @endif
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold">{{ $field->name }}</h3>
                            <span
                                class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $field->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class='bx bx-star text-yellow-400 mr-1'></i>
                            <span class="font-semibold">{{ $field->rating ?? 'N/A' }}</span>
                            <span class="text-gray-600 ml-2">({{ $field->reviews_count ?? 0 }} review)</span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ $field->description }}</p>
                        <div class="flex justify-between items-center">
                            <span
                                class="text-2xl font-bold text-green-600">Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</span>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
                                onclick="openBookingModal()">
                                Booking
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
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
