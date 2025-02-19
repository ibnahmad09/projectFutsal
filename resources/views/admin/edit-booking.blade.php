@extends('layouts.admin')

@section('title', 'Edit Booking - FUTSALDESA')

@section('content')
<div class="p-6 space-y-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold neon-text">
            <i class='bx bx-edit mr-2'></i>
            Edit Booking
        </h1>
    </div>

    <!-- Form Section -->
    <div class="cyber-table rounded-xl p-6">
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Field Selection -->
            <div class="mb-6">
                <label class="block text-gray-400 mb-2">Lapangan</label>
                <select name="field_id" class="bg-gray-800 px-4 py-2 rounded-lg w-full">
                    @foreach($fields as $field)
                        <option value="{{ $field->id }}" 
                            {{ $booking->field_id == $field->id ? 'selected' : '' }}>
                            {{ $field->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-400 mb-2">Tanggal Booking</label>
                    <input type="date" name="booking_date" 
                           value="{{ $booking->booking_date->format('Y-m-d') }}"
                           class="bg-gray-800 px-4 py-2 rounded-lg w-full">
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Waktu</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="time" name="start_time" 
                               value="{{ $booking->start_time }}"
                               class="bg-gray-800 px-4 py-2 rounded-lg">
                        <input type="time" name="end_time" 
                               value="{{ $booking->end_time }}"
                               class="bg-gray-800 px-4 py-2 rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Status and Payment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-400 mb-2">Status</label>
                    <select name="status" class="bg-gray-800 px-4 py-2 rounded-lg w-full">
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-400 mb-2">Total Harga</label>
                    <input type="text" value="Rp{{ number_format($booking->total_price, 0, ',', '.') }}"
                           class="bg-gray-800 px-4 py-2 rounded-lg w-full" readonly>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('admin.bookings.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 px-6 py-2 rounded-lg">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 px-6 py-2 rounded-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection