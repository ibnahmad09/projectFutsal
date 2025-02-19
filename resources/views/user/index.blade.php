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

    <!-- Real-time Schedule Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Jadwal Real-time</h2>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 font-semibold">
                <div>Lapangan</div>
                <div>Pemesan</div>
                <div>Waktu</div>
                <div>Status</div>
            </div>

            <div id="real-time-schedule">
                <!-- Data akan diisi oleh JavaScript -->
                <div class="text-center py-4 text-gray-500">Memuat data...</div>
            </div>
        </div>
    </div>

    <script>
        function fetchRealTimeSchedule() {
            fetch('/api/real-time-schedule')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('real-time-schedule');
                    if (data.length > 0) {
                        container.innerHTML = data.map(booking => `
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 py-2 border-b last:border-b-0">
                                <div>${booking.field_name}</div>
                                <div>${booking.user_name}</div>
                                <div>${booking.start_time} - ${booking.end_time}</div>
                                <div class="capitalize">
                                    <span class="px-2 py-1 rounded-full text-sm 
                                        ${booking.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                        booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                        'bg-red-100 text-red-800'}">
                                        ${booking.status}
                                    </span>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        container.innerHTML =
                            '<div class="text-center py-4 text-gray-500">Tidak ada jadwal saat ini</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Fetch data pertama kali
        fetchRealTimeSchedule();

        // Update data setiap 1 menit
        setInterval(fetchRealTimeSchedule, 60000);
    </script>

    <style>
        #real-time-schedule {
            max-height: 400px;
            overflow-y: auto;
        }

        #real-time-schedule>div {
            transition: background-color 0.3s ease;
        }

        #real-time-schedule>div:hover {
            background-color: #f3f4f6;
        }
    </style>

@endsection
