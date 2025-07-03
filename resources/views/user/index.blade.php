@extends('layouts.user')

@section('title', 'Home')


@section('content')

    @extends('user.booking')



    <div class="bg-blue-100 p-4 rounded-lg mb-6">
        @if(auth()->user()->member && auth()->user()->member->is_active)
            <p>Anda sedang menjalani proses member. Minggu ke-{{ auth()->user()->member->weeks_completed }} dari 4 minggu.</p>
        @else
            <p>Jadilah member dan dapatkan gratis bermain satu kali! <a href="https://wa.me/6282226866782" class="text-blue-600">Ajukan sekarang via WA Admin</a></p>
        @endif
    </div>
    <!-- Hero Section -->
    <div class="pt-20 pb-12 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Sewa Lapangan Futsal Desa</h1>
                <p class="text-lg mb-8">Booking lapangan favoritmu kapan saja, dimana saja!</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8 text-center">Jadwal Booking</h2>

        <div class="bg-white rounded-xl shadow-md p-4 md:p-6">
            <!-- Desktop View -->
            <div class="hidden md:block">
                <div class="grid grid-cols-5 gap-4 mb-4 font-semibold p-3 bg-gray-50 rounded-lg">
                    <div>Lapangan</div>
                    <div>Pemesan</div>
                    <div>Waktu</div>
                    <div>Status</div>
                    <div>Tipe</div>
                </div>

                <div id="real-time-schedule" class="space-y-2">
                    <div class="text-center py-4 text-gray-500">Memuat data...</div>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                <div id="real-time-schedule-mobile" class="space-y-3">
                    <div class="text-center py-4 text-gray-500">Memuat data...</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetchRealTimeSchedule() {
            fetch('/api/real-time-schedule', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const desktopContainer = document.getElementById('real-time-schedule');
                const mobileContainer = document.getElementById('real-time-schedule-mobile');

                if (data.length > 0) {
                    // Desktop View
                    desktopContainer.innerHTML = data.map(booking => `
                        <div class="grid grid-cols-5 gap-4 p-3 bg-white rounded-lg hover:bg-gray-50 transition-all">
                            <div class="flex items-center">${booking.field_name}</div>
                            <div class="flex items-center">${booking.user_name}</div>
                            <div class="flex items-center">${formatDate(booking.booking_date)}<br>${formatTime(booking.start_time)} - ${formatTime(booking.end_time)}</div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 rounded-full text-sm
                                    ${booking.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                    booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    'bg-red-100 text-red-800'}">
                                    ${booking.status}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 rounded-full text-sm
                                    ${booking.type === 'ongoing' ? 'bg-blue-100 text-blue-800' :
                                    'bg-purple-100 text-purple-800'}">
                                    ${booking.type === 'ongoing' ? 'Sedang Berjalan' : 'Akan Datang'}
                                </span>
                            </div>
                        </div>
                    `).join('');

                    // Mobile View
                    mobileContainer.innerHTML = data.map(booking => `
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <div class="font-medium">Lapangan</div>
                                    <div>${booking.field_name}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="font-medium">Pemesan</div>
                                    <div>${booking.user_name}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="font-medium">Waktu</div>
                                    <div>${formatDate(booking.booking_date)}<br>${formatTime(booking.start_time)} - ${formatTime(booking.end_time)}</div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="font-medium">Status</div>
                                    <div>
                                        <span class="px-2 py-1 rounded-full text-sm
                                            ${booking.status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                            booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                            'bg-red-100 text-red-800'}">
                                            ${booking.status}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="font-medium">Tipe</div>
                                    <div>
                                        <span class="px-2 py-1 rounded-full text-sm
                                            ${booking.type === 'ongoing' ? 'bg-blue-100 text-blue-800' :
                                            'bg-purple-100 text-purple-800'}">
                                            ${booking.type === 'ongoing' ? 'Sedang Berjalan' : 'Akan Datang'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    desktopContainer.innerHTML =
                        '<div class="text-center py-4 text-gray-500">Tidak ada jadwal saat ini</div>';
                    mobileContainer.innerHTML =
                        '<div class="text-center py-4 text-gray-500">Tidak ada jadwal saat ini</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const desktopContainer = document.getElementById('real-time-schedule');
                const mobileContainer = document.getElementById('real-time-schedule-mobile');
                desktopContainer.innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat data jadwal</div>';
                mobileContainer.innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat data jadwal</div>';
            });
        }

        // Fetch data pertama kali
        fetchRealTimeSchedule();

        // Update data setiap 1 menit
        setInterval(fetchRealTimeSchedule, 60000);

        function formatTime(dateString) {
            // Pastikan dateString adalah string waktu dalam format HH:mm
            if (typeof dateString === 'string' && dateString.includes(':')) {
                return dateString; // Langsung kembalikan string waktu jika sudah dalam format yang benar
            }

            // Jika dateString adalah objek Date atau timestamp
            const date = new Date(dateString);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function formatDate(dateString) {
            // Jika dateString sudah dalam format yyyy-mm-dd
            if (typeof dateString === 'string' && dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                const [year, month, day] = dateString.split('-');
                return `${day}-${month}-${year}`;
            }
            // Jika dateString adalah objek Date atau timestamp
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }
    </script>

    <style>
        #real-time-schedule {
            max-height: 500px;
            overflow-y: auto;
        }

        #real-time-schedule-mobile {
            max-height: 600px;
            overflow-y: auto;
        }

        /* Scrollbar styling */
        #real-time-schedule::-webkit-scrollbar,
        #real-time-schedule-mobile::-webkit-scrollbar {
            width: 6px;
        }

        #real-time-schedule::-webkit-scrollbar-track,
        #real-time-schedule-mobile::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #real-time-schedule::-webkit-scrollbar-thumb,
        #real-time-schedule-mobile::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #real-time-schedule::-webkit-scrollbar-thumb:hover,
        #real-time-schedule-mobile::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>


    <!-- Daftar Lapangan -->
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold mb-8 text-center">Lapangan Tersedia</h2>

            <div class="grid grid-cols-1 gap-6">
                @foreach ($fields as $field)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
                        @if ($field->images && $field->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $field->images->first()->image_path) }}" alt="Lapangan"
                                class="h-96 w-full object-cover">
                        @else
                            <img src="https://source.unsplash.com/random/1920x1080?futsal" alt="Lapangan"
                                class="h-96 w-full object-cover">
                        @endif
                        <div class="p-8">
                            <div class="flex justify-between items-start mb-6">
                                <h3 class="text-3xl font-bold">{{ $field->name }}</h3>
                                <span
                                    class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-lg">{{ $field->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                            </div>
                            <div class="flex items-center mb-4">
                                <i class='bx bx-star text-yellow-400 mr-2 text-2xl'></i>
                                <span class="font-semibold text-xl">{{ $field->rating ?? 'N/A' }}</span>
                                <span class="text-gray-600 ml-3 text-lg">({{ $field->reviews_count ?? 0 }} review)</span>
                            </div>
                            <p class="text-gray-600 mb-6 text-lg">{{ $field->description }}</p>
                            <div class="flex justify-between items-center">
                                <span
                                    class="text-3xl font-bold text-green-600">Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</span>
                                <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-lg"
                                    onclick="openBookingModal({{ $field->id }})">
                                    Booking Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
