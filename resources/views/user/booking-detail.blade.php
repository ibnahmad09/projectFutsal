@extends('layouts.user')

@section('content')
<br>br
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Detail Booking</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informasi Booking -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Informasi Booking</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-600">Kode Booking:</p>
                        <p class="font-medium">{{ $booking->booking_code }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal:</p>
                        <p class="font-medium">{{ $booking->booking_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Waktu:</p>
                        <p class="font-medium">{{ $booking->start_time }} - {{ $booking->end_time }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Durasi:</p>
                        <p class="font-medium">{{ $booking->duration }} Jam</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Lapangan -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Informasi Lapangan</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-600">Nama Lapangan:</p>
                        <p class="font-medium">{{ $booking->field->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Lokasi:</p>
                        <p class="font-medium">{{ $booking->field->location }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Harga per Jam:</p>
                        <p class="font-medium">Rp{{ number_format($booking->field->price_per_hour, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Informasi Pembayaran</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-gray-600">Metode Pembayaran:</p>
                    <p class="font-medium">{{ ucfirst($booking->payment_method) }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Total Harga:</p>
                    <p class="font-medium">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status:</p>
                    <p class="font-medium {{ $booking->status === 'confirmed' ? 'text-green-600' : 'text-red-600' }}">
                        {{ ucfirst($booking->status) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-8">
            <a href="{{ route('user.home.index') }}"
               class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
