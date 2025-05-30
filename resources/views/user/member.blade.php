@extends('layouts.user')

@section('title', 'Menu Member')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Menu Member</h1>

        @if(auth()->user()->member && auth()->user()->member->is_active)
            <div class="mb-6">
                <p class="text-gray-700">Anda sedang menjalani proses member. Minggu ke-{{ auth()->user()->member->weeks_completed }} dari 4 minggu.</p>
                <p class="text-gray-700">Total bermain: {{ $totalPlayed }} kali</p>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Jadwal yang Harus Dibooking</h2>
                @if($requiredBookings->isEmpty())
                    <p class="text-gray-700">Tidak ada jadwal yang harus dibooking minggu ini.</p>
                @else
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Tanggal</th>
                                <th class="py-2 px-4 border-b">Waktu Mulai</th>
                                <th class="py-2 px-4 border-b">Waktu Selesai</th>
                                <th class="py-2 px-4 border-b">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requiredBookings as $booking)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $booking->booking_date }}</td>
                                <td class="py-2 px-4 border-b">{{ $booking->start_time }}</td>
                                <td class="py-2 px-4 border-b">{{ $booking->end_time }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if($booking->status == 'confirmed')
                                        <span class="text-green-600">Dikonfirmasi</span>
                                    @else
                                        <span class="text-yellow-600">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="mb-6">
                @if(auth()->user()->member && auth()->user()->member->weeks_completed >= 4 && !auth()->user()->member->is_member_used)
                    <a href="{{ route('user.member.use') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg">Gunakan Fitur Member</a>
                @endif
            </div>
        @else
            <p class="text-gray-700">Anda belum menjadi member. <a href="https://wa.me/6281234567890" class="text-blue-600">Ajukan sekarang via WA Admin</a></p>
        @endif
    </div>
</div>
@endsection
