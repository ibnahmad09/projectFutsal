@extends('layouts.user')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Riwayat Booking</h1>

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-4 text-left">Kode Booking</th>
                    <th class="p-4 text-left">Lapangan</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Waktu</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $booking->booking_code }}</td>
                    <td class="p-4">{{ $booking->field->name }}</td>
                    <td class="p-4">{{ $booking->booking_date->format('d M Y') }}</td>
                    <td class="p-4">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-sm
                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="p-4">
                        <a href="{{ route('user.bookings.show', $booking) }}"
                           class="text-green-600 hover:text-green-800">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @foreach($bookings as $booking)
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $booking->booking_code }}</h3>
                    <p class="text-sm text-gray-600">{{ $booking->field->name }}</p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs
                    @if($booking->status == 'confirmed') bg-green-100 text-green-800
                    @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>

            <div class="space-y-2 mb-4">
                <div class="flex items-center text-sm">
                    <i class='bx bx-calendar text-gray-500 mr-2'></i>
                    <span>{{ $booking->booking_date->format('d M Y') }}</span>
                </div>
                <div class="flex items-center text-sm">
                    <i class='bx bx-time text-gray-500 mr-2'></i>
                    <span>{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                </div>
            </div>

            <div class="pt-3 border-t">
                <a href="{{ route('user.bookings.show', $booking) }}"
                   class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition-colors block">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
