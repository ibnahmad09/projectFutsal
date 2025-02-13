@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
<br><br>
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-6">
            <h1 class="text-3xl font-bold text-white">Edit Profil</h1>
            <p class="text-green-200 mt-2">Perbarui informasi profil Anda</p>
        </div>

        <!-- Form -->
        <div class="p-6">
            <form method="POST" action="{{ route('update.profile') }}">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                           required>
                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 border rounded-lg bg-gray-100 cursor-not-allowed"
                           disabled>
                </div>

                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number" 
                           value="{{ old('phone_number', $user->phone_number) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                           required>
                    @error('phone_number')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-medium mb-2">Alamat</label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                              required>{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('user.profil.show') }}" 
                       class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection