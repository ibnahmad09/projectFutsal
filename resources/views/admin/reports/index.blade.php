@extends('layouts.admin')

@section('title', 'Laporan - FUTSALDESA')

@section('content')
<div class="p-6 space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold flex items-center">
            <i class='bx bx-file mr-2 text-green-400'></i>
            Daftar Laporan
        </h1>
        <a href="{{ route('admin.reports.create') }}" 
           class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center">
            <i class='bx bx-plus mr-2'></i>
            Buat Laporan Baru
        </a>
    </div>

    <!-- Filter Section -->
    <div class="mb-6 bg-gray-800 p-4 rounded-lg">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select name="type" class="p-2 bg-gray-700 rounded-lg">
                <option value="">Semua Jenis</option>
                <option value="financial" {{ request('type') == 'financial' ? 'selected' : '' }}>Keuangan</option>
                <option value="booking" {{ request('type') == 'booking' ? 'selected' : '' }}>Booking</option>
                <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Pengguna</option>
            </select>
            <input type="date" name="start_date" class="p-2 bg-gray-700 rounded-lg" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="p-2 bg-gray-700 rounded-lg" value="{{ request('end_date') }}">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                Filter
            </button>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="hologram-effect p-6 rounded-xl">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="p-3 text-left">Judul</th>
                        <th class="p-3 text-left">Jenis</th>
                        <th class="p-3 text-left">Tanggal Mulai</th>
                        <th class="p-3 text-left">Tanggal Akhir</th>
                        <th class="p-3 text-left">Format</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr class="border-b border-gray-700 hover:bg-gray-800">
                        <td class="p-3">{{ $report->title }}</td>
                        <td class="p-3 capitalize">{{ $report->type }}</td>
                        <td class="p-3">{{ $report->start_date->format('d M Y') }}</td>
                        <td class="p-3">{{ $report->end_date->format('d M Y') }}</td>
                        <td class="p-3 uppercase">
                            @if($report->file_path)
                                {{ pathinfo($report->file_path, PATHINFO_EXTENSION) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex items-center space-x-4">
                                @if($report->file_path)
                                <a href="{{ asset($report->file_path) }}" 
                                   class="text-green-400 hover:text-green-500"
                                   title="Download">
                                    <i class='bx bx-download text-xl'></i>
                                </a>
                                @endif
                                <a href="{{ route('admin.reports.show', $report) }}" 
                                   class="text-blue-400 hover:text-blue-500"
                                   title="Detail">
                                    <i class='bx bx-show text-xl'></i>
                                </a>
                                <form action="{{ route('admin.reports.destroy', $report) }}" 
                                      method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-400 hover:text-red-500"
                                            title="Hapus">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection