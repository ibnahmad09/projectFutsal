@extends('layouts.admin')

@section('title', 'Admin Cyber Booking - FUTSALDESA')

@section('content')

  <!-- Field Management Content -->
  <main class="p-6 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <h1 class="text-3xl font-bold neon-text mb-4 md:mb-0">
            <i class='bx bx-football mr-2'></i>
            Kelola Lapangan
        </h1>
        <div class="flex gap-4">
            {{-- <button class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg flex items-center">
                <i class='bx bx-plus mr-2'></i> <a href="{{ route('admin.fields.create') }}"> Add New Field </a>
            </button> --}}
            <button class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg flex items-center">
                <i class='bx bx-filter-alt mr-2'></i> Filters
            </button>
        </div>
    </div>

    <!-- Field Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="hologram-effect p-4 rounded-xl">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ $field ? 1 : 0 }}</div>
                    <div class="text-sm text-green-400">Jumlah Lapangan</div>
                </div>
                <i class='bx bx-stats text-3xl text-green-400'></i>
            </div>
        </div>
        <div class="hologram-effect p-4 rounded-xl">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ $field ? ($field->is_available ? 1 : 0) : 0 }}</div>
                    <div class="text-sm text-green-400">Tersedia Sekarang</div>
                </div>
                <i class='bx bx-check-circle text-3xl text-green-400'></i>
            </div>
        </div>
        <div class="hologram-effect p-4 rounded-xl">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ number_format($field ? $field->occupancy_rate : 0, 0) }}%</div>
                    <div class="text-sm text-green-400">Avg Occupancy</div>
                </div>
                <i class='bx bx-trending-up text-3xl text-green-400'></i>
            </div>
        </div>
        <div class="hologram-effect p-4 rounded-xl">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">Rp{{ number_format($field ? $field->price_per_hour : 0, 0, ',', '.') }}</div>
                    <div class="text-sm text-green-400">Total Harga Sewa lapangan</div>
                </div>
                <i class='bx bx-coin text-3xl text-green-400'></i>
            </div>
        </div>
    </div>

    <!-- Fields Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-6">
        <div class="field-card p-6 rounded-xl">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-xl font-bold">{{ $field->name }}</h3>
                    <span class="text-sm text-green-400 capitalize">{{ $field->type }}</span>
                </div>
                <span class="px-2 py-1 rounded-full {{ $field->status === 'available' ? 'bg-green-900' : 'bg-red-900' }} text-green-400 text-sm">
                    {{ ucfirst($field->status) }}
                </span>
            </div>

            <div class="mb-4 relative">
                @if($field->images && $field->images->count() > 0)
                <img src="{{ asset('storage/'.$field->images->first()->image_path) }}"
                     class="w-full h-48 object-cover rounded-lg">
                @else
                <div class="w-full h-48 bg-gray-800 rounded-lg flex items-center justify-center">
                    <i class='bx bx-image text-4xl text-gray-500'></i>
                </div>
                @endif
                <div class="absolute bottom-2 right-2 flex gap-2">
                    <a href="{{ route('admin.fields.edit', $field->id) }}"
                       class="p-2 bg-gray-900 rounded-lg hover:bg-green-600">
                        <i class='bx bx-edit'></i>
                    </a>
                    <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-2 bg-gray-900 rounded-lg hover:bg-red-600"
                                onclick="return confirm('Are you sure?')">
                            <i class='bx bx-trash'></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span>Price/Hour</span>
                    <span class="font-bold text-green-400">
                        Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span>Operating Hours</span>
                    <span>{{ date('H:i', strtotime($field->open_time)) }} - {{ date('H:i', strtotime($field->close_time)) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span>Size</span>
                    <span>{{ $field->size }}</span>
                </div>

                @if($field->facilities)
                <div class="pt-3 border-t border-gray-700">
                    <div class="text-sm text-gray-400">Facilities:</div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach(json_decode($field->facilities) as $facility)
                        <span class="px-2 py-1 text-sm rounded-full bg-gray-800">
                            {{ ucfirst($facility) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="cyber-table rounded-xl overflow-hidden">
        <div class="p-4 border-b border-green-900 flex flex-col md:flex-row justify-between items-start md:items-center">
             <div class="mb-4 md:mb-0">
                 <input type="text" placeholder="Search fields..."
                        class="bg-gray-800 px-4 py-2 rounded-lg w-full md:w-64">
             </div>
             <div class="flex items-center gap-4">
                 <select class="bg-gray-800 px-4 py-2 rounded-lg">
                     <option>All Types</option>
                     <option>Indoor</option>
                     <option>Outdoor</option>
                 </select>
                 <select class="bg-gray-800 px-4 py-2 rounded-lg">
                     <option>All Status</option>
                     <option>Available</option>
                     <option>Maintenance</option>
                 </select>
             </div>
         </div>

         <div class="overflow-x-auto">
             <table class="w-full">
                 <thead class="bg-gray-800">
                     <tr>
                         <th class="p-4 text-left">Nama Lapangan</th>
                         <th class="p-4 text-left">Tipe</th>
                         <th class="p-4 text-left">Status</th>
                         <th class="p-4 text-left">Harga Sewa/Jam</th>
                         <th class="p-4 text-left">Jam Operasional</th>
                         <th class="p-4 text-left">Aksi</th>
                     </tr>
                 </thead>
                 <tbody>
                     @if($field)
                     <tr class="border-b border-gray-700 hover:bg-gray-800 transition">
                         <td class="p-4 font-bold">{{ $field->name }}</td>
                         <td class="p-4">
                             <span class="px-2 py-1 rounded-full bg-blue-900 text-blue-400 capitalize">
                                 {{ $field->type }}
                             </span>
                         </td>
                         <td class="p-4">
                             <div class="flex items-center">
                                 <div class="w-2 h-2 {{ $field->status === 'available' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                 {{ ucfirst($field->status) }}
                             </div>
                         </td>
                         <td class="p-4 text-green-400">
                             Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}
                         </td>
                         <td class="p-4">
                             {{ date('H:i', strtotime($field->open_time)) }} - {{ date('H:i', strtotime($field->close_time)) }}
                         </td>
                         <td class="p-4">
                             <div class="flex gap-2">
                                 <a href="{{ route('admin.fields.edit', $field->id) }}"
                                    class="p-2 hover:bg-gray-700 rounded-lg">
                                     <i class='bx bx-edit text-green-400'></i>
                                 </a>
                                 <form action="{{ route('admin.fields.destroy', $field->id) }}" method="POST">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit"
                                             class="p-2 hover:bg-gray-700 rounded-lg"
                                             onclick="return confirm('Are you sure?')">
                                         <i class='bx bx-trash text-red-400'></i>
                                     </button>
                                 </form>
                             </div>
                         </td>
                     </tr>
                     @else
                     <tr>
                         <td colspan="6" class="p-4 text-center text-gray-400">Belum ada lapangan yang tersedia</td>
                     </tr>
                     @endif
                 </tbody>
             </table>
         </div>
     </div>

    <!-- Field Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="hologram-effect p-6 rounded-xl">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <i class='bx bx-bar-chart-alt text-green-400 mr-2'></i>
                Monthly Bookings per Field
            </h3>
            <canvas id="fieldPerformanceChart" class="w-full h-64"></canvas>
        </div>

        <div class="hologram-effect p-6 rounded-xl">
            <h3 class="text-xl font-bold mb-4 flex items-center">
                <i class='bx bx-pie-chart text-green-400 mr-2'></i>
                Field Type Distribution
            </h3>
            <canvas id="fieldTypeChart" class="w-full h-64"></canvas>
        </div>
    </div>
</main>
</div>
</div>

<script>
// Ubah data chart untuk menangani satu lapangan
const fieldPerformanceData = {
    labels: ['{{ $field->name ?? 'Lapangan' }}'],
    data: [{{ $field->bookings_count ?? 0 }}]
};

const fieldTypeData = {
    labels: ['{{ $field->type ?? 'Indoor' }}'],
    data: [1]
};

// Field Performance Chart
const fieldPerfCtx = document.getElementById('fieldPerformanceChart').getContext('2d');
new Chart(fieldPerfCtx, {
    type: 'bar',
    data: {
        labels: fieldPerformanceData.labels, // Menggunakan data dari database
        datasets: [{
            label: 'Bookings',
            data: fieldPerformanceData.data, // Menggunakan data dari database
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

// Field Type Chart
const fieldTypeCtx = document.getElementById('fieldTypeChart').getContext('2d');
new Chart(fieldTypeCtx, {
    type: 'doughnut',
    data: {
        labels: fieldTypeData.labels, // Menggunakan data dari database
        datasets: [{
            data: fieldTypeData.data, // Menggunakan data dari database
            backgroundColor: ['#10B981', '#3B82F6']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'right' },
        }
    }
});
</script>

@endsection
