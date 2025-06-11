@extends('layouts.user')

@section('title', 'Lapangan')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative h-screen">
        @if ($field->images && $field->images->isNotEmpty())
            <img src="{{ asset('storage/' . $field->images->first()->image_path) }}"
                 alt="{{ $field->name }}"
                 class="w-full h-full object-cover">
        @else
            <img src="https://source.unsplash.com/random/1920x1080?futsal"
                 alt="{{ $field->name }}"
                 class="w-full h-full object-cover">
        @endif

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
            <div class="text-center text-white max-w-2xl px-4">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">{{ $field->name }}</h1>
                <p class="text-lg md:text-xl mb-8">{{ $field->description }}</p>

                <!-- Status & Price -->
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 inline-block">
                    <div class="flex items-center justify-center space-x-6">
                        <div>
                            <span class="text-sm">Status</span>
                            <div class="text-2xl font-bold {{ $field->is_available ? 'text-green-400' : 'text-red-400' }}">
                                {{ $field->is_available ? 'Tersedia' : 'Penuh' }}
                            </div>
                        </div>
                        <div class="h-12 w-px bg-white/20"></div>
                        <div>
                            <span class="text-sm">Harga</span>
                            <div class="text-2xl font-bold">
                                Rp{{ number_format($field->price_per_hour, 0, ',', '.') }}/jam
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Button -->
                <div class="mt-8">
                    <button onclick="openBookingModal({{ $field->id }})"
                            class="bg-green-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-green-700 transition">
                        🏀 Booking Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Booking Modal -->
@include('user.booking')

<script>
function openBookingModal(fieldId) {
    document.getElementById('field_id').value = fieldId;
    document.getElementById('bookingModal').classList.remove('hidden');
    loadAvailableTimes();
}
</script>
@endsection