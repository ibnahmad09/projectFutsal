@extends('layouts.admin')

@section('title', ' Dashboard - FUTSALDESA')

@section('content')



        <!-- Cyber Dashboard Content -->
        <main class="p-6 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <div class="hologram-effect p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $totalBookings }}</div>
                            <div class="text-sm text-green-400">Total Bookings</div>
                        </div>
                        <i class='bx bx-calendar-event text-3xl text-green-400'></i>
                    </div>
                    <div class="mt-2 h-1 bg-gray-700">
                        <div class="h-full bg-green-400 w-3/4"></div>
                    </div>
                </div>

                <div class="hologram-effect p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-2xl font-bold">Rp{{ number_format($todayRevenue, 0, ',', '.') }}</div>
                            <div class="text-sm text-green-400">Today's Revenue</div>
                        </div>
                        <i class='bx bx-credit-card text-3xl text-green-400'></i>
                    </div>
                    <div class="mt-2 h-1 bg-gray-700">
                        <div class="h-full bg-green-400 w-2/3"></div>
                    </div>
                </div>

                <div class="hologram-effect p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $activeUsers }}</div>
                            <div class="text-sm text-green-400">Active Users</div>
                        </div>
                        <i class='bx bx-user-check text-3xl text-green-400'></i>
                    </div>
                    <div class="mt-2 h-1 bg-gray-700">
                        <div class="h-full bg-green-400 w-1/2"></div>
                    </div>
                </div>

                <div class="hologram-effect p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-2xl font-bold">{{ $fieldOccupancy }}%</div>
                            <div class="text-sm text-green-400">Field Occupancy</div>
                        </div>
                        <i class='bx bx-trending-up text-3xl text-green-400'></i>
                    </div>
                    <div class="mt-2 h-1 bg-gray-700">
                        <div class="h-full bg-green-400 w-4/5"></div>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Bookings -->
                <div class="lg:col-span-2 hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-time-five text-green-400 mr-2'></i>
                        Recent Bookings
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th class="p-3 text-left">Booking Code</th>
                                    <th class="p-3 text-left">Customer</th>
                                    <th class="p-3 text-left">Field</th>
                                    <th class="p-3 text-left">Time</th>
                                    <th class="p-3 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
                                <tr class="border-b border-gray-700 hover:bg-gray-800">
                                    <td class="p-3">{{ $booking->booking_code }}</td>
                                    <td class="p-3">{{ $booking->user->name }}</td>
                                    <td class="p-3">{{ $booking->field->name }}</td>
                                    <td class="p-3">{{ date('H:i', strtotime($booking->start_time)) }} - {{ date('H:i', strtotime($booking->end_time)) }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 rounded-full
                                            @if($booking->status == 'confirmed') bg-green-900 text-green-400
                                            @elseif($booking->status == 'pending') bg-yellow-900 text-yellow-400
                                            @else bg-red-900 text-red-400 @endif text-sm">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="w-full mt-4 p-2 bg-green-600 hover:bg-green-700 rounded-lg text-center block">
                        View All Bookings
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-bolt text-green-400 mr-2'></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.fields.create') }}" class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-plus text-2xl mb-2'></i>
                            <span class="text-sm">Add New Field</span>
                        </a>
                        <a href="{{ route('admin.reports.create') }}" class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-file text-2xl mb-2'></i>
                            <span class="text-sm">Generate Report</span>
                        </a>
                        <a href="" class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-user-plus text-2xl mb-2'></i>
                            <span class="text-sm">Manage Users</span>
                        </a>
                        <a href="" class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-money text-2xl mb-2'></i>
                            <span class="text-sm">View Payments</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Analytics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-line-chart text-green-400 mr-2'></i>
                        Booking Trends
                    </h3>
                    <canvas id="bookingChart" class="w-full h-48 md:h-64"></canvas>
                </div>

                <div class="hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-bar-chart-alt text-green-400 mr-2'></i>
                        Field Performance
                    </h3>
                    <canvas id="fieldChart" class="w-full h-48 md:h-64"></canvas>
                </div>
            </div>
        </main>

    </div>
</div>

<script>
    // Booking Trends Chart
    const bookingCtx = document.getElementById('bookingChart').getContext('2d');
    new Chart(bookingCtx, {
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
                legend: { display: false },
            },
            scales: {
                y: { grid: { color: '#374151' }, ticks: { color: '#9CA3AF' } },
                x: { grid: { color: '#374151' }, ticks: { color: '#9CA3AF' } }
            }
        }
    });

    // Field Performance Chart
    const fieldCtx = document.getElementById('fieldChart').getContext('2d');
    new Chart(fieldCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($fieldPerformanceData['labels']) !!},
            datasets: [{
                label: 'Occupancy Rate',
                data: {!! json_encode($fieldPerformanceData['data']) !!},
                backgroundColor: '#10B981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: { grid: { color: '#374151' }, ticks: { color: '#9CA3AF' } },
                x: { grid: { color: '#374151' }, ticks: { color: '#9CA3AF' } }
            }
        }
    });
</script>


@endsection
