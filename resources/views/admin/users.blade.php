@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Manajemen User</h1>

    <div class="cyber-table rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-800">
                <tr>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">No. HP</th>
                    <th class="p-4 text-left">Total Booking</th>
                    <th class="p-4 text-left">Bergabung</th>
                    <th class="p-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b border-gray-700 hover:bg-gray-800 transition">
                    <td class="p-4">{{ $user->name }}</td>
                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4">{{ $user->phone_number }}</td>
                    <td class="p-4">{{ $user->bookings_count }}</td>
                    <td class="p-4">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="p-4">
                        <div class="flex items-center">
                            <div class="status-dot {{ $user->email_verified_at ? 'bg-green-500' : 'bg-gray-500' }}"></div>
                            <span class="ml-2">{{ $user->email_verified_at ? 'Verified' : 'Unverified' }}</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
