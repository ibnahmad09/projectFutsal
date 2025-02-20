@extends('layouts.admin')

@section('title', 'Analytics - FUTSALDESA')

@section('content')
<div class="p-6 space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold flex items-center">
            <i class='bx bx-line-chart text-green-400 mr-2'></i>
            Analytics Dashboard
        </h1>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Booking Trends -->
        <div class="hologram-effect p-6 rounded-xl">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <i class='bx bx-trending-up text-green-400 mr-2'></i>
                Booking Trends
            </h3>
            <canvas id="bookingTrendChart" class="w-full h-64"></canvas>
        </div>

        <!-- User Growth -->
        <div class="hologram-effect p-6 rounded-xl">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <i class='bx bx-user-plus text-green-400 mr-2'></i>
                User Growth
            </h3>
            <canvas id="userGrowthChart" class="w-full h-64"></canvas>
        </div>

        <!-- Field Performance -->
        <div class="hologram-effect p-6 rounded-xl">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <i class='bx bx-bar-chart-alt text-green-400 mr-2'></i>
                Field Performance
            </h3>
            <canvas id="fieldPerformanceChart" class="w-full h-64"></canvas>
        </div>

        <!-- Revenue -->
        <div class="hologram-effect p-6 rounded-xl">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <i class='bx bx-money text-green-400 mr-2'></i>
                Revenue
            </h3>
            <canvas id="revenueChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>

<script>
    // Booking Trends Chart
    const bookingCtx = document.getElementById('bookingTrendChart').getContext('2d');
    new Chart(bookingCtx, {
        type: 'line',
        data: {
            labels: @json($bookingTrends['labels']),
            datasets: [{
                label: 'Bookings',
                data: @json($bookingTrends['data']),
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

    // User Growth Chart
    const userCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userCtx, {
        type: 'line',
        data: {
            labels: @json($userGrowth['labels']),
            datasets: [{
                label: 'Users',
                data: @json($userGrowth['data']),
                borderColor: '#3B82F6',
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
    const fieldCtx = document.getElementById('fieldPerformanceChart').getContext('2d');
    new Chart(fieldCtx, {
        type: 'bar',
        data: {
            labels: @json($fieldPerformance['labels']),
            datasets: [{
                label: 'Bookings',
                data: @json($fieldPerformance['data']),
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

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueData['data']),
                backgroundColor: '#3B82F6',
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