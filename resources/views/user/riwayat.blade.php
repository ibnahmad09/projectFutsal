@extends('layouts.user')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Riwayat Booking</h1>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
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

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
