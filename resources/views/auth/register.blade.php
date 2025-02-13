@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gray-800 text-white py-4 px-6">
                <h2 class="text-2xl font-bold">{{ __('Daftar Akun Baru') }}</h2>
                <p class="text-sm text-gray-300 mt-1">Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold">Masuk disini</a>
                </p>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="space-y-5">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Nama Lengkap') }}</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   class="w-full px-3 py-2 border rounded-md @error('name') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Alamat Email') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                                   class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="w-full px-3 py-2 border rounded-md @error('password') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password Input -->
                        <div>
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Konfirmasi Password') }}</label>
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Phone Number Input -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Nomor Telepon') }}</label>
                            <input id="phone_number" type="text" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="tel"
                                   class="w-full px-3 py-2 border rounded-md @error('phone_number') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Input -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Alamat Lengkap') }}</label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}" required autocomplete="street-address"
                                   class="w-full px-3 py-2 border rounded-md @error('address') border-red-500 @else border-gray-300 @enderror
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md
                                           transition duration-200 ease-in-out transform hover:scale-105">
                                {{ __('Daftar Sekarang') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
