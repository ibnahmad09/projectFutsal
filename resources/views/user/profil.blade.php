@extends('layouts.user')

@section('title','Profil')

@section('content')
    <!-- Profile Header -->
    <div class="pt-20 pb-12 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-6 md:mb-0">
                    <div class="relative">
                        @php
                            $colors = ['bg-green-600', 'bg-blue-600', 'bg-purple-600', 'bg-pink-600', 'bg-indigo-600'];
                            $colorIndex = ord(Str::lower(Str::substr($user->name, 0, 1))) % count($colors);
                            $colorClass = $colors[$colorIndex];
                        @endphp

                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-lg {{ $colorClass }} flex items-center justify-center text-white text-4xl font-bold">
                            {{ Str::substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl md:text-3xl font-bold text-white">{{ $user->name }}</h1>
                        <p class="text-green-200 text-sm md:text-base">Member sejak {{ $user->created_at->format('Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('user.profil.edit') }}"
                    class="bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full text-white hover:bg-white/30 transition text-sm md:text-base">
                    <i class='bx bx-edit mr-2'></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Akun -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
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
                            <p class="font-medium">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-green-600 text-white p-6 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm">Total Booking</p>
                                <p class="text-2xl font-bold">{{ $user->bookings->count() }}</p>
                            </div>
                            <i class='bx bx-calendar-check text-3xl opacity-75'></i>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-6">
                <!-- Keamanan -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <i class='bx bx-shield-alt mr-2 text-green-600'></i>
                        Keamanan
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span>Verifikasi Email</span>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </span>
                        </div>

                        <!-- Form Ubah Password -->
                        <form method="POST" action="{{ route('user.profil.update-password') }}">
                            @csrf
                            @method('PUT')

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-gray-600 mb-1">Password Saat Ini</label>
                                    <input type="password" name="current_password" required
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>

                                <div>
                                    <label class="block text-gray-600 mb-1">Password Baru</label>
                                    <input type="password" name="password" required
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>

                                <div>
                                    <label class="block text-gray-600 mb-1">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" required
                                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                                </div>

                                <button type="submit"
                                        class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif
@endsection