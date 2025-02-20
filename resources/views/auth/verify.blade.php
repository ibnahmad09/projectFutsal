@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-50 to-green-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.839-8.63a2.25 2.25 0 010 3.464l-8.84 4.76a2.25 2.25 0 01-2.17 0l-8.84-4.76a2.25 2.25 0 010-3.464l8.84-4.76a2.25 2.25 0 012.17 0l8.84 4.76z" />
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Verifikasi Email Anda
            </h2>
        </div>

        <div class="mt-8 space-y-6">
            @if (session('resent'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Tautan verifikasi baru telah dikirim ke alamat email Anda.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <p class="text-gray-600 text-center">
                Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.
            </p>
            <p class="text-gray-600 text-center">
                Jika Anda tidak menerima email,
            </p>

            <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="mt-4 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                    Kirim Ulang Tautan Verifikasi
                    <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-sm text-gray-600 hover:text-gray-900">
                    Kembali ke Halaman Login
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
