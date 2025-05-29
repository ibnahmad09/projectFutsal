@extends('layouts.admin')

@section('title', 'Daftar Member - FUTSALDESA')

@section('content')
<div class="p-6 space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold flex items-center">
            <i class='bx bx-user mr-2 text-green-400'></i>
            Daftar Member
        </h1>
        <a href="{{ route('members.create') }}"
           class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 flex items-center">
            <i class='bx bx-plus mr-2'></i>
            Tambah Member
        </a>
    </div>

    <!-- Members Table -->
    <div class="bg-gray-800 p-4 rounded-lg">
        <table class="w-full">
            <thead class="bg-gray-700">
                <tr>
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Nama User</th>
                    <th class="p-4 text-left">Tanggal Mulai</th>
                    <th class="p-4 text-left">Minggu Diselesaikan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                    <td class="p-4">{{ $member->id }}</td>
                    <td class="p-4">{{ $member->user->name }}</td>
                    <td class="p-4">{{ $member->start_date }}</td>
                    <td class="p-4">{{ $member->weeks_completed }}</td>
                    <td class="p-4">
                        @if($member->is_active)
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">Aktif</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <button onclick="updateWeeksCompleted({{ $member->id }})"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Tambah Minggu
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $members->links() }}
    </div>
</div>

<script>
function updateWeeksCompleted(memberId) {
    if (confirm('Apakah Anda yakin ingin menambah minggu untuk member ini?')) {
        fetch(`/admin/members/${memberId}/update-weeks`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
}
</script>
@endsection
