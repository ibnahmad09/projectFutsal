@extends('layouts.user')

@section('content')

    <a href="{{ route('user.bookings.show', $payment->booking) }}"
       class="mt-6 inline-block bg-green-600 text-white px-6 py-3 rounded-lg">
        Lihat Detail Booking
    </a>
</div>
@endsection
