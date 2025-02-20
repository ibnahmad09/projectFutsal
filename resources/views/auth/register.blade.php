@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-6 px-8">
                <h2 class="text-3xl font-bold flex items-center">
                    <i class="fas fa-user-plus mr-3"></i>{{ __('Daftar Akun Baru') }}
                </h2>
                <p class="text-sm text-gray-100 mt-2">Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-green-200 hover:text-green-100 font-semibold">Masuk disini</a>
                </p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user text-gray-500 mr-2"></i>{{ __('Nama Lengkap') }}
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   class="w-full px-4 py-3 border rounded-lg @error('name') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                          transition duration-200 ease-in-out">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-envelope text-gray-500 mr-2"></i>{{ __('Alamat Email') }}
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                   class="w-full px-4 py-3 border rounded-lg @error('email') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                          transition duration-200 ease-in-out">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-lock text-gray-500 mr-2"></i>{{ __('Password') }}
                            </label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="w-full px-4 py-3 border rounded-lg @error('password') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                          transition duration-200 ease-in-out">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div>
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-lock text-gray-500 mr-2"></i>{{ __('Konfirmasi Password') }}
                            </label>
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- Phone Number Input -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-phone text-gray-500 mr-2"></i>{{ __('Nomor Telepon') }}
                            </label>
                            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel"
                                   class="w-full px-4 py-3 border rounded-lg @error('phone_number') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                          transition duration-200 ease-in-out">
                            @error('phone_number')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address Input -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>{{ __('Alamat Lengkap') }}
                            </label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="street-address"
                                   class="w-full px-4 py-3 border rounded-lg @error('address') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                                          transition duration-200 ease-in-out">
                            @error('address')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold py-3 px-4 rounded-lg
                                           transition duration-200 ease-in-out transform hover:scale-[1.02] shadow-lg
                                           flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2"></i>{{ __('Daftar Sekarang') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
