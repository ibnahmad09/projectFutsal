@extends('layouts.admin')

@section('title', 'Generate Report - FUTSALDESA')

@section('content')
<div class="p-6 space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold flex items-center">
            <i class='bx bx-file mr-2 text-green-400'></i>
           Generate Laporan
        </h1>
    </div>

    <!-- Report Form -->
    <div class="hologram-effect p-6 rounded-xl">
        <form action="{{ route('admin.reports.store') }}" method="POST">
            @csrf

            <!-- Report Title -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Judul Laporan</label>
                <input type="text" name="title" class="w-full p-3 bg-gray-800 rounded-lg focus:ring-2 focus:ring-green-400" required>
            </div>

            <!-- Report Type -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Jenis Laporan</label>
                <select name="type" class="w-full p-3 bg-gray-800 rounded-lg focus:ring-2 focus:ring-green-400">
                    <option value="financial">Laporan Keuangan</option>
                    <option value="booking">Laporan Booking</option>
                    <option value="user">Laporan Pengguna</option>
                </select>
            </div>

            <!-- Date Range -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="w-full p-3 bg-gray-800 rounded-lg focus:ring-2 focus:ring-green-400">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="w-full p-3 bg-gray-800 rounded-lg focus:ring-2 focus:ring-green-400">
                </div>
            </div>

            <!-- Report Options -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Format Laporan</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="flex items-center p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700">
                        <input type="radio" name="format" value="pdf" class="mr-2" checked>
                        <span>PDF</span>
                    </label>
                    <label class="flex items-center p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700">
                        <input type="radio" name="format" value="excel" class="mr-2">
                        <span>Excel</span>
                    </label>
                    <label class="flex items-center p-4 bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-700">
                        <input type="radio" name="format" value="csv" class="mr-2">
                        <span>CSV</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <button type="reset" class="px-6 py-2 bg-gray-700 rounded-lg hover:bg-gray-600">
                    Reset
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 rounded-lg hover:bg-green-700 flex items-center">
                    <i class='bx bx-download mr-2'></i>
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Recent Reports -->
    <div class="hologram-effect p-6 rounded-xl">
        <h2 class="text-xl font-bold mb-4 flex items-center">
            <i class='bx bx-history mr-2 text-green-400'></i>
            Laporan Terakhir
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="p-3 text-left">Judul</th>
                        <th class="p-3 text-left">Jenis</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Format</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentReports as $report)
                    <tr class="border-b border-gray-700 hover:bg-gray-800">
                        <td class="p-3">{{ $report->title }}</td>
                        <td class="p-3 capitalize">{{ $report->type }}</td>
                        <td class="p-3">{{ $report->created_at->format('d M Y') }}</td>
                        <td class="p-3 uppercase">{{ $report->file_path ? pathinfo($report->file_path, PATHINFO_EXTENSION) : '-' }}</td>
                        <td class="p-3">
                            @if($report->file_path)
                            <a href="{{ asset($report->file_path) }}" class="text-green-400 hover:text-green-500">
                                <i class='bx bx-download'></i>
                            </a>
                            @else
                            <span class="text-gray-500">Tidak tersedia</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection