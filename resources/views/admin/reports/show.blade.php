@extends('layouts.admin')

@section('title', 'Detail Laporan - FUTSALDESA')

@section('content')
<div class="p-6 space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold flex items-center">
            <i class='bx bx-file mr-2 text-green-400'></i>
            Detail Laporan
        </h1>
        <a href="{{ route('admin.reports.index') }}" 
           class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-700 flex items-center">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali
        </a>
    </div>

    <!-- Report Details -->
    <div class="hologram-effect p-6 rounded-xl space-y-6">
        <!-- Basic Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-400 mb-1">Judul Laporan</label>
                <p class="text-white text-lg font-medium">{{ $report->title }}</p>
            </div>
            <div>
                <label class="block text-gray-400 mb-1">Jenis Laporan</label>
                <p class="text-white text-lg font-medium capitalize">{{ $report->type }}</p>
            </div>
            <div>
                <label class="block text-gray-400 mb-1">Tanggal Mulai</label>
                <p class="text-white text-lg font-medium">{{ $report->start_date->format('d M Y') }}</p>
            </div>
            <div>
                <label class="block text-gray-400 mb-1">Tanggal Akhir</label>
                <p class="text-white text-lg font-medium">{{ $report->end_date->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Report Content -->
        <div>
            <label class="block text-gray-400 mb-1">Isi Laporan</label>
            <div class="bg-gray-800 p-4 rounded-lg">
                <pre class="text-white whitespace-pre-wrap">{{ json_encode($report->content, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>

        <!-- File Section -->
        <div>
            <label class="block text-gray-400 mb-1">File Laporan</label>
            @if($report->file_path)
            <a href="{{ asset($report->file_path) }}" 
               class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center w-fit">
                <i class='bx bx-download mr-2'></i>
                Download Laporan
            </a>
            @else
            <p class="text-gray-400">Tidak ada file yang tersedia</p>
            @endif
        </div>

        @if($report->type === 'financial')
        <div class="bg-gray-800 p-4 rounded-lg mt-6">
            <h3 class="text-lg font-semibold mb-4">Detail Keuangan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-400">Total Pendapatan</p>
                    <p class="text-white">Rp{{ number_format($report->content['total_revenue'], 0, ',', '.') }}</p>
                </div>
                @foreach($report->content['payment_statuses'] as $status => $count)
                <div>
                    <p class="text-gray-400">Transaksi {{ ucfirst($status) }}</p>
                    <p class="text-white">{{ $count }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 