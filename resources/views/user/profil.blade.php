@extends('layouts.user')

@section('title','Profil')


@section('content')
    <!-- Profile Header -->
    <div class="pt-20 pb-16 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-6 md:mb-0">
                    <div class="relative">
                        <img src="https://source.unsplash.com/random/200x200?person"
                             class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                        <button class="absolute bottom-0 right-0 bg-green-500 p-2 rounded-full hover:bg-green-600 transition">
                            <i class='bx bx-camera text-white text-xl'></i>
                        </button>
                    </div>
                    <div class="ml-6">
                        <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                        <p class="text-green-200">Member sejak {{ $user->created_at->format('Y') }}</p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <button class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-white hover:bg-white/30 transition">
                        <i class='bx bx-edit mr-2'></i>Edit Profil
                    </button>
                    <button class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-white hover:bg-white/30 transition">
                        <i class='bx bx-cog mr-2'></i>Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Profil Anda</h2>

        <form method="POST" action="{{ route('update.profile') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="address" class="block text-gray-600 mb-1">Alamat</label>
                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', Auth::user()->address) }}" required>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            <!-- Kolom Kiri -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Akun -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-info-circle mr-2 text-green-600'></i>
                        Informasi Akun
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-600 mb-1">Nama Lengkap</label>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Email</label>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Nomor Telepon</label>
                            <p class="font-medium">{{ $user->phone_number }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Bergabung Pada</label>
                            <p class="font-medium">{{ $user->created_at }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-600 text-white p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm">Total Booking</p>
                                <p class="text-3xl font-bold">24</p>
                            </div>
                            <i class='bx bx-calendar-check text-4xl opacity-75'></i>
                        </div>
                    </div>
                    <div class="bg-green-500 text-white p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm">Member Aktif</p>
                                <p class="text-3xl font-bold">2 Tahun</p>
                            </div>
                            <i class='bx bx-time-five text-4xl opacity-75'></i>
                        </div>
                    </div>
                    <div class="bg-green-400 text-white p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm">Rating</p>
                                <p class="text-3xl font-bold">4.8</p>
                            </div>
                            <i class='bx bx-star text-4xl opacity-75'></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-6">
                <!-- Keamanan -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-shield-alt mr-2 text-green-600'></i>
                        Keamanan
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span>Verifikasi Email</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                Terverifikasi
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Kata Sandi</span>
                            <button class="text-green-600 hover:text-green-700">
                                Ubah
                            </button>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>2FA</span>
                            <label class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <span class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Booking Terbaru -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-history mr-2 text-green-600'></i>
                        Booking Terbaru
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium">Lapangan 1</p>
                                <p class="text-sm text-gray-600">20 Jun 2024 • 19:00-21:00</p>
                            </div>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                Aktif
                            </span>
                        </div>

                        <div class="text-center py-8 text-gray-500">
                            <i class='bx bx-calendar-exclamation text-4xl mb-4'></i>
                            <p>Tidak ada booking aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (Sama seperti sebelumnya) -->

    <style>
        .toggle-checkbox:checked {
            right: 0;
            border-color: #059669;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #059669;
        }
    </style>

@endsection
