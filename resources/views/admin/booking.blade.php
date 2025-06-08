@extends('layouts.admin')

@section('title', 'Admin Cyber Booking - FUTSALDESA')

<!-- Tambahkan ini untuk SweetAlert2 -->
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
@endpush

@section('content')

    <!-- Booking Management Content -->
    <main class="p-6 space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <h1 class="text-3xl font-bold neon-text mb-4 md:mb-0">
                <i class='bx bx-calendar-check mr-2'></i>
                Booking Management
            </h1>
            <div class="flex gap-4">
                <!-- Tambahkan tombol Input Manual -->
                <button onclick="openManualBookingModal()" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg flex items-center">
                    <i class='bx bx-plus mr-2'></i> Input Manual
                </button>
                <button class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg flex items-center">
                    <i class='bx bx-filter-alt mr-2'></i> Filters
                </button>
            </div>
        </div>

        <!-- Modal Input Manual Booking -->
        <div id="manualBookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-gray-900 rounded-lg w-full max-w-2xl p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Input Booking Manual</h3>
                    <button onclick="closeManualBookingModal()" class="text-gray-400 hover:text-white">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>

                <!-- Form -->
                <form id="manualBookingForm" onsubmit="submitManualBooking(event)">
                    @csrf
                    <!-- Step 1: Informasi Dasar -->
                    <div id="manualStep1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 mb-2">Nama Penyewa</label>
                                <input type="text" name="customer_name" required
                                    class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Nomor Telepon</label>
                                <input type="tel" name="customer_phone" required
                                    class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 mb-2">Lapangan</label>
                                <select name="field_id" required class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg">
                                    @foreach($fields as $field)
                                        <option value="{{ $field->id }}">{{ $field->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Tanggal Booking</label>
                                <input type="date" name="booking_date" required
                                    class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg"
                                    min="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-300 mb-2">Waktu Mulai</label>
                                <select name="start_time" id="start_time" required class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg">
                                    <option value="">Pilih Waktu</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-300 mb-2">Durasi (Jam)</label>
                                <select name="duration" id="duration" required class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg">
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}">{{ $i }} Jam</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-300 mb-2">Metode Pembayaran</label>
                            <select name="payment_method" required class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg">
                                <option value="cash">Tunai di Tempat</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" onclick="closeManualBookingModal()"
                            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Simpan Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="hologram-effect p-4 rounded-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-2xl font-bold">{{ $totalBookings }}</div>
                        <div class="text-sm text-green-400">Total Bookings</div>
                    </div>
                    <i class='bx bx-line-chart text-3xl text-green-400'></i>
                </div>
            </div>
            <!-- Tambahkan 3 card statistik lainnya -->
        </div>

        <!-- Booking Table -->
        <div class="cyber-table rounded-xl overflow-hidden">
            <div
                class="p-4 border-b border-green-900 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="mb-4 md:mb-0">
                    <input type="text" placeholder="Search bookings..."
                        class="bg-gray-800 px-4 py-2 rounded-lg w-full md:w-64">
                </div>
                <div class="flex items-center gap-4">
                    <select class="bg-gray-800 px-4 py-2 rounded-lg">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Confirmed</option>
                        <option>Completed</option>
                        <option>Canceled</option>
                    </select>
                    <input type="date" class="bg-gray-800 px-4 py-2 rounded-lg">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="p-4 text-left">Kode Booking</th>
                            <th class="p-4 text-left">Customer</th>
                            <th class="p-4 text-left">Lapangan</th>
                            <th class="p-4 text-left">Tanggal dan Waktu</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-left">Total</th>
                            <th class="p-4 text-left">Terima / Tidak</th>
                            <th class="p-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Booking Item 1 -->
                        @foreach ($bookings as $booking)
                            <tr class="border-b border-gray-700 hover:bg-gray-800 transition">
                                <td class="p-4 font-mono text-green-400">{{ $booking->booking_code }}</td>
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-700 mr-3"></div>
                                        @if($booking->is_manual_booking)
                                            {{ $booking->customer_name }}
                                        @else
                                            {{ $booking->user ? $booking->user->name : 'User tidak tersedia' }}
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">{{ $booking->field->name }}</td>
                                <td class="p-4">
                                    {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}<br>
                                    <span
                                        class="text-green-400">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                        - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <div class="status-dot bg-green-500 mr-2"></div>
                                        <span
                                            class="badge
                                                @if ($booking->status == 'pending') bg-warning
                                                @elseif($booking->status == 'confirmed') bg-success
                                                @else bg-danger @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @if ($booking->status == 'pending')
                                        <div class="flex gap-2">
                                            <form action="{{ route('admin.bookings.accept', $booking->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="p-2 hover:bg-gray-700 rounded-lg">
                                                    <i class='bx bx-check text-green-400'></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.bookings.reject', $booking->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="p-2 hover:bg-gray-700 rounded-lg">
                                                    <i class='bx bx-x text-red-400'></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Tidak ada aksi</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                            class="p-2 hover:bg-gray-700 rounded-lg">
                                            <i class='bx bx-show text-green-400'></i>
                                        </a>
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                            class="p-2 hover:bg-gray-700 rounded-lg">
                                            <i class='bx bx-edit text-green-400'></i>
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 hover:bg-gray-700 rounded-lg">
                                                <i class='bx bx-trash text-red-400'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Tambahkan baris booking lainnya -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-green-900 flex justify-between items-center">
                <div class="text-gray-400">Showing 1-10 of 142 bookings</div>
                <div class="flex gap-2">
                    <button class="p-2 hover:bg-gray-700 rounded-lg">
                        <i class='bx bx-chevron-left'></i>
                    </button>
                    <button class="p-2 bg-gray-700 rounded-lg">1</button>
                    <button class="p-2 hover:bg-gray-700 rounded-lg">2</button>
                    <button class="p-2 hover:bg-gray-700 rounded-lg">3</button>
                    <button class="p-2 hover:bg-gray-700 rounded-lg">
                        <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="hologram-effect p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class='bx bx-trending-up text-green-400 mr-2'></i>
                    Booking Trends
                </h3>
                <canvas id="bookingTrendChart" class="w-full h-64"></canvas>
            </div>

            <div class="hologram-effect p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class='bx bx-pie-chart-alt text-green-400 mr-2'></i>
                    Status Distribution
                </h3>
                <canvas id="statusChart" class="w-full h-64"></canvas>
            </div>
        </div>
    </main>
    </div>
    </div>

    <script>
        // Booking Trend Chart
        const trendCtx = document.getElementById('bookingTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($bookingTrends['labels']) !!},
                datasets: [{
                    label: 'Bookings',
                    data: {!! json_encode($bookingTrends['data']) !!},
                    borderColor: '#10B981',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        grid: {
                            color: '#374151'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    },
                    x: {
                        grid: {
                            color: '#374151'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    }
                }
            }
        });

        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusDistribution['labels']) !!},
                datasets: [{
                    data: {!! json_encode($statusDistribution['data']) !!},
                    backgroundColor: [
                        '#10B981',
                        '#F59E0B',
                        '#3B82F6',
                        '#EF4444'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                }
            }
        });

        // Tambahkan event listener untuk field dan tanggal
        document.querySelector('select[name="field_id"]').addEventListener('change', loadAvailableTimes);
        document.querySelector('input[name="booking_date"]').addEventListener('change', loadAvailableTimes);

        async function loadAvailableTimes() {
            const fieldId = document.querySelector('select[name="field_id"]').value;
            const date = document.querySelector('input[name="booking_date"]').value;
            const startTimeSelect = document.getElementById('start_time');

            if (!fieldId || !date) {
                startTimeSelect.innerHTML = '<option value="">Pilih Waktu</option>';
                return;
            }

            try {
                const response = await fetch(`/api/available-times/${fieldId}?date=${date}`);
                const data = await response.json();

                // Kosongkan select
                startTimeSelect.innerHTML = '<option value="">Pilih Waktu</option>';

                // Tambahkan opsi waktu yang tersedia
                data.available_slots.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    startTimeSelect.appendChild(option);
                });

                // Jika tidak ada waktu yang tersedia
                if (data.available_slots.length === 0) {
                    startTimeSelect.innerHTML = '<option value="">Tidak ada waktu tersedia</option>';
                }
            } catch (error) {
                console.error('Error loading available times:', error);
                startTimeSelect.innerHTML = '<option value="">Error loading times</option>';
            }
        }

        // Tambahkan validasi durasi berdasarkan waktu yang tersedia
        document.getElementById('duration').addEventListener('change', validateDuration);
        document.getElementById('start_time').addEventListener('change', validateDuration);

        async function validateDuration() {
            const fieldId = document.querySelector('select[name="field_id"]').value;
            const date = document.querySelector('input[name="booking_date"]').value;
            const startTime = document.getElementById('start_time').value;
            const duration = parseInt(document.getElementById('duration').value);

            if (!fieldId || !date || !startTime || !duration) return;

            try {
                const response = await fetch(`/api/available-times/${fieldId}?date=${date}`);
                const data = await response.json();

                // Buat array dari semua slot yang dibutuhkan
                const requiredSlots = [];
                const start = new Date(`2000-01-01T${startTime}`);

                for (let i = 0; i < duration; i++) {
                    const slotTime = new Date(start.getTime() + (i * 60 * 60 * 1000));
                    requiredSlots.push(slotTime.toTimeString().slice(0, 5));
                }

                // Debug: Tampilkan slot yang dibutuhkan dan yang tersedia
                console.log('Required Slots:', requiredSlots);
                console.log('Available Slots:', data.available_slots);

                // Cek apakah semua slot yang dibutuhkan tersedia
                const unavailableSlots = requiredSlots.filter(slot => !data.available_slots.includes(slot));

                if (unavailableSlots.length > 0) {
                    console.log('Unavailable Slots:', unavailableSlots);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Durasi Tidak Tersedia',
                        text: `Slot waktu berikut tidak tersedia: ${unavailableSlots.join(', ')}`
                    });
                    document.getElementById('duration').value = '1';
                }
            } catch (error) {
                console.error('Error validating duration:', error);
            }
        }

        // Tambahkan script untuk modal manual booking
        function openManualBookingModal() {
            document.getElementById('manualBookingModal').classList.remove('hidden');
        }

        function closeManualBookingModal() {
            document.getElementById('manualBookingModal').classList.add('hidden');
            document.getElementById('manualBookingForm').reset();
        }

        async function submitManualBooking(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('{{ route("admin.bookings.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                // Cek tipe konten response
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server tidak mengembalikan response JSON yang valid');
                }

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Booking berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(result.message || 'Terjadi kesalahan');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Terjadi kesalahan sistem'
                });
            }
        }
    </script>
@endsection
