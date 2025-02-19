@extends('layouts.admin')

@section('title', 'Admin Cyber Booking - FUTSALDESA')

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
                <button class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg flex items-center">
                    <i class='bx bx-filter-alt mr-2'></i> Filters
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="hologram-effect p-4 rounded-xl">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-2xl font-bold">142</div>
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
                                        {{ $booking->user->name }}
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
    </script>
@endsection
