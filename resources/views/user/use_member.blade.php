@extends('layouts.user')

@section('title', 'Gunakan Fitur Member')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Gunakan Fitur Member</h1>

        <form action="{{ route('user.member.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="field_id" class="block text-gray-700">Pilih Lapangan</label>
                <select name="field_id" id="field_id" class="form-control" required>
                    @foreach($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="booking_date" class="block text-gray-700">Tanggal Booking</label>
                <input type="date" name="booking_date" id="booking_date" class="form-control" required>
            </div>
            <div class="mb-4">
                <label for="start_time" class="block text-gray-700">Waktu Mulai</label>
                <input type="time" name="start_time" id="start_time" class="form-control" required>
            </div>
            <div class="mb-4">
                <label for="duration" class="block text-gray-700">Durasi (Jam)</label>
                <input type="number" name="duration" id="duration" class="form-control" min="1" max="4" required>
            </div>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg">Booking Gratis</button>
        </form>
    </div>
</div>
@endsection
