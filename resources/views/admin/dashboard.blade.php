@extends('layouts.admin')

@section('title', 'Admin Cyber Dashboard - FUTSALDESA')

@section('content')



        <!-- Cyber Dashboard Content -->
        <main class="p-6 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="hologram-effect p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-2xl font-bold">24</div>
                            <div class="text-sm text-green-400">Active Bookings</div>
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
                            <div class="text-2xl font-bold">₿12.4K</div>
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
                            <div class="text-2xl font-bold">156</div>
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
                            <div class="text-2xl font-bold">82%</div>
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
                                <tr class="border-b border-gray-700 hover:bg-gray-800">
                                    <td class="p-3">#FUT234</td>
                                    <td class="p-3">John Doe</td>
                                    <td class="p-3">Field 1</td>
                                    <td class="p-3">19:00-21:00</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 rounded-full bg-green-900 text-green-400 text-sm">
                                            Confirmed
                                        </span>
                                    </td>
                                </tr>
                                <!-- More rows -->
                            </tbody>
                        </table>
                    </div>
                    <button class="w-full mt-4 p-2 bg-green-600 hover:bg-green-700 rounded-lg">
                        View All Bookings
                    </button>
                </div>

                <!-- Quick Actions -->
                <div class="hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-bolt text-green-400 mr-2'></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-plus text-2xl mb-2'></i>
                            <span class="text-sm">Add New Field</span>
                        </button>
                        <button class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-file text-2xl mb-2'></i>
                            <span class="text-sm">Generate Report</span>
                        </button>
                        <button class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-user-plus text-2xl mb-2'></i>
                            <span class="text-sm">Manage Users</span>
                        </button>
                        <button class="p-4 bg-gray-800 rounded-lg hover:bg-green-600 transition flex flex-col items-center">
                            <i class='bx bx-money text-2xl mb-2'></i>
                            <span class="text-sm">View Payments</span>
                        </button>
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
                    <canvas id="bookingChart" class="w-full h-64"></canvas>
                </div>

                <div class="hologram-effect p-6 rounded-xl">
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-bar-chart-alt text-green-400 mr-2'></i>
                        Field Performance
                    </h3>
                    <canvas id="fieldChart" class="w-full h-64"></canvas>
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
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Bookings',
                data: [12, 19, 3, 5, 2, 3],
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
            labels: ['Field 1', 'Field 2', 'Field 3'],
            datasets: [{
                label: 'Occupancy Rate',
                data: [65, 59, 80],
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
