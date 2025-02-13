{{-- resources/views/bookings/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Buat Booking')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Booking Lapangan</h1>

        <form method="POST" action="{{ route('admin.bookings.store') }}">
            @csrf

            <!-- Field Selection -->
            <div class="mb-6">
                <label for="field_id" class="block text-gray-700 mb-2">Pilih Lapangan *</label>
                <select name="field_id" id="field_id"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500" required
                        onchange="updatePrice()">
                    <option value="">-- Pilih Lapangan --</option>
                    @foreach($fields as $field)
                        <option value="{{ $field->id }}"
                            data-price="{{ $field->price_per_hour }}"
                            data-open="{{ $field->open_time->format('H:i') }}"
                            data-close="{{ $field->close_time->format('H:i') }}">
                            {{ $field->name }} (Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date Picker -->
            <div class="mb-6">
                <label for="booking_date" class="block text-gray-700 mb-2">Tanggal Booking *</label>
                <input type="date" id="booking_date" name="booking_date"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
            </div>

            <!-- Time Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start_time" class="block text-gray-700 mb-2">Waktu Mulai *</label>
                    <input type="time" id="start_time" name="start_time"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500" required
                           onchange="calculateDuration()">
                </div>

                <div>
                    <label for="end_time" class="block text-gray-700 mb-2">Waktu Selesai *</label>
                    <input type="time" id="end_time" name="end_time"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500" required
                           onchange="calculateDuration()">
                </div>
            </div>

            <!-- Duration & Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 mb-2">Durasi</label>
                    <input type="text" id="duration"
                           class="w-full p-2 border rounded-lg bg-gray-50" readonly>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Total Harga</label>
                    <input type="text" id="total_price" name="total_price"
                           class="w-full p-2 border rounded-lg bg-gray-50" readonly>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mb-6">
                <label for="payment_method" class="block text-gray-700 mb-2">Metode Pembayaran *</label>
                <select name="payment_method" id="payment_method"
                        class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-green-500" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="e_wallet">E-Wallet</option>
                </select>
            </div>

            <button type="submit"
                    class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition">
                Lanjut ke Pembayaran
            </button>
        </form>
    </div>
</div>

<script>
function updatePrice() {
    const fieldSelect = document.getElementById('field_id');
    const pricePerHour = fieldSelect.options[fieldSelect.selectedIndex].dataset.price;
    calculateDuration(pricePerHour);
}

function calculateDuration() {
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    const pricePerHour = document.getElementById('field_id').selectedOptions[0]?.dataset.price || 0;

    if(startTime && endTime) {
        const [startHour, startMinute] = startTime.split(':').map(Number);
        const [endHour, endMinute] = endTime.split(':').map(Number);

        let duration = (endHour * 60 + endMinute) - (startHour * 60 + startMinute);
        duration = duration / 60; // Convert to hours

        if(duration > 0) {
            document.getElementById('duration').value = `${duration} Jam`;
            document.getElementById('total_price').value =
                `Rp${(duration * pricePerHour).toLocaleString('id-ID')}`;
        } else {
            document.getElementById('duration').value = 'Invalid time';
            document.getElementById('total_price').value = 'Rp0';
        }
    }
}
</script>
@endsection
