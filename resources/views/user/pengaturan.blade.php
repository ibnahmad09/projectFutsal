@extends('layouts.user')

@section('title', 'Pengaturan')

@section('content')
    <!-- Header -->
    <div class="pt-20 pb-16 bg-gradient-to-r from-green-600 to-green-800">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-white flex items-center">
                <i class='bx bx-cog mr-2'></i>
                Pengaturan
            </h1>
            <p class="text-green-200 mt-2">Kelola preferensi dan keamanan akun Anda</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Keamanan Akun -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-shield-alt mr-2 text-green-600'></i>
                        Keamanan Akun
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">Verifikasi Email</p>
                                <p class="text-sm text-gray-500">Pastikan email Anda terverifikasi</p>
                            </div>
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">Kata Sandi</p>
                                <p class="text-sm text-gray-500">Ubah kata sandi Anda secara berkala</p>
                            </div>
                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Ubah Kata Sandi
                            </button>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">Autentikasi Dua Faktor (2FA)</p>
                                <p class="text-sm text-gray-500">Tingkatkan keamanan akun Anda</p>
                            </div>
                            <label class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <span class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-bell mr-2 text-green-600'></i>
                        Pengaturan Notifikasi
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">Email Notifikasi</p>
                                <p class="text-sm text-gray-500">Terima pemberitahuan melalui email</p>
                            </div>
                            <label class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" checked/>
                                <span class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></span>
                            </label>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">SMS Notifikasi</p>
                                <p class="text-sm text-gray-500">Terima pemberitahuan melalui SMS</p>
                            </div>
                            <label class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <span class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-6">
                <!-- Privasi -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-lock-alt mr-2 text-green-600'></i>
                        Privasi
                    </h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">Profil Publik</p>
                                <p class="text-sm text-gray-500">Tampilkan profil Anda ke publik</p>
                            </div>
                            <label class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <span class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></span>
                            </label>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">Riwayat Booking</p>
                                <p class="text-sm text-gray-500">Tampilkan riwayat booking Anda</p>
                            </div>
                            <label class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <span class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Hapus Akun -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <i class='bx bx-trash mr-2 text-red-600'></i>
                        Hapus Akun
                    </h2>
                    <p class="text-gray-600 mb-4">Hapus akun Anda secara permanen. Aksi ini tidak dapat dibatalkan.</p>
                    <button class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        Hapus Akun Saya
                    </button>
                </div>
            </div>
        </div>
    </div>

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