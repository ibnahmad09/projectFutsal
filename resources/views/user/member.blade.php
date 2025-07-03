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
                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu Mulai</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu Selesai</th>
                                    <th scope="col" class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($requiredBookings as $booking)
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="py-2 px-4 whitespace-nowrap text-sm text-gray-800">{{ $booking->booking_date }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap text-sm text-gray-800">{{ $booking->start_time }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap text-sm text-gray-800">{{ $booking->end_time }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap text-sm">
                                        @if($booking->status == 'confirmed')
                                            <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">Dikonfirmasi</span>
                                        @else
                                            <span class="inline-block px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
