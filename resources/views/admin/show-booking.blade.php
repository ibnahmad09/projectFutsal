@extends('layouts.admin')

@section('title', 'Detail Booking - FUTSALDESA')

@section('content')
    <main class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold neon-text">
                <i class='bx bx-calendar-check mr-2'></i>
                Detail Booking
            </h1>
            <a href="{{ route('admin.bookings.index') }}" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg flex items-center">
                <i class='bx bx-arrow-back mr-2'></i> Kembali
            </a>
        </div>

        <!-- Booking Details Card -->
        <div class="hologram-effect p-6 rounded-xl space-y-6">
            <!-- Informasi Booking -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-info-circle text-green-400 mr-2'></i>
                        Informasi Booking
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-400">Kode Booking:</p>
                            <p class="font-medium text-green-400">{{ $booking->booking_code }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Tanggal:</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Waktu:</p>
                            <p class="font-medium text-green-400">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-400">Status:</p>
                            <span class="badge 
                                @if($booking->status == 'pending') bg-warning
                                @elseif($booking->status == 'confirmed') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Lapangan -->
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center">
                        <i class='bx bx-football text-green-400 mr-2'></i>
                        Informasi Lapangan
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-400">Nama Lapangan:</p>
                            <p class="font-medium">{{ $booking->field->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Lokasi:</p>
                            <p class="font-medium">{{ $booking->field->location }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Harga per Jam:</p>
                            <p class="font-medium">Rp{{ number_format($booking->field->price_per_hour, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class='bx bx-credit-card text-green-400 mr-2'></i>
                    Informasi Pembayaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-400">Metode Pembayaran:</p>
                        <p class="font-medium">{{ ucfirst($booking->payment_method) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Total Harga:</p>
                        <p class="font-medium text-green-400">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Customer -->
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <i class='bx bx-user text-green-400 mr-2'></i>
                    Informasi Customer
                </h3>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center">
                        <i class='bx bx-user text-xl'></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $booking->user->name }}</p>
                        <p class="text-gray-400">{{ $booking->user->phone_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection