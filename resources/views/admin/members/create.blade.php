@extends('layouts.admin')

@section('title', 'Tambah Member - FUTSALDESA')

@section('content')
    <main class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold neon-text">
                <i class='bx bx-user-plus mr-2'></i>
                Tambah Member
            </h1>
            <a href="{{ route('members.index') }}" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded-lg flex items-center">
                <i class='bx bx-arrow-back mr-2'></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="hologram-effect p-6 rounded-xl">
            <form action="{{ route('members.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- User Selection -->
                <div>
                    <label for="user_id" class="block text-gray-400 mb-2">Pilih User</label>
                    <select name="user_id" id="user_id"
                            class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none focus:ring-2 focus:ring-green-500"
                            required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-gray-400 mb-2">Tanggal Mulai</label>
                    <input type="date"
                           name="start_date"
                           id="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg p-3 input-glow focus:outline-none focus:ring-2 focus:ring-green-500"
                           required>
                    @error('start_date')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg flex items-center transition duration-200">
                        <i class='bx bx-save mr-2'></i>
                        Simpan Member
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
