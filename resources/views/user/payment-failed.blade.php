@extends('layouts.user')

@section('content')
<div class="text-center mt-20">
    <h1 class="text-3xl font-bold text-red-600 mb-4">Pembayaran Gagal atau Dibatalkan</h1>
    <p class="text-lg">Silakan coba lagi atau hubungi admin jika mengalami kendala.</p>
    <a href="{{ route('user.bookings.index') }}" class="mt-6 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Kembali ke Daftar Booking</a>
</div>
@endsection
