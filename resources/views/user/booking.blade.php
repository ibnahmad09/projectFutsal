<!-- Modal Booking -->
<div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Booking Lapangan</h3>
            <button onclick="closeBookingModal()" class="text-gray-500 hover:text-gray-700">
                &times;
            </button>
        </div>

        <!-- Form -->
        <form id="bookingForm" onsubmit="submitBooking(event)">
            <input type="hidden" id="field_id" value="{{ $field->id }}">

            <!-- Step 1: Pilih Jadwal -->
            <div id="step1">
                <div class="mb-4">
                    <label class="block mb-2">Tanggal Booking</label>
                    <input type="date" id="booking_date"
                           class="w-full p-2 border rounded-lg"
                           min="{{ now()->format('Y-m-d') }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Pilih Waktu</label>
                    <div class="grid grid-cols-3 gap-2" id="timeSlots">
                        <!-- Time slots akan diisi via JS -->
                    </div>
                    <small class="text-gray-500">Slot tersedia: 07:00-22:00 (1 jam per slot)</small>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Durasi</label>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="changeDuration(-1)" class="px-3 py-1 bg-gray-100 rounded">-</button>
                        <input type="number" id="duration" value="1" min="1" max="4"
                               class="w-20 text-center border rounded" readonly>
                        <button type="button" onclick="changeDuration(1)" class="px-3 py-1 bg-gray-100 rounded">+</button>
                        <span>Jam</span>
                    </div>
                </div>
            </div>

            <!-- Step 2: Konfirmasi -->
            <div id="step2" class="hidden">
                <div class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span>Lapangan:</span>
                        <span id="confirmField">{{ $field->name }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Tanggal:</span>
                        <span id="confirmDate"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Waktu:</span>
                        <span id="confirmTime"></span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Durasi:</span>
                        <span id="confirmDuration"></span>
                    </div>
                    <div class="flex justify-between font-bold">
                        <span>Total:</span>
                        <span id="confirmPrice"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Metode Pembayaran</label>
                    <select id="payment_method" class="w-full p-2 border rounded-lg" required>
                        <option value="cash">Tunai di Tempat</option>
                        <option value="e-wallet">E-Wallet</option>
                    </select>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between mt-4">
                <button type="button" onclick="closeBookingModal()"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded">
                    Batal
                </button>
                <div class="flex gap-2">
                    <button type="button" id="prevBtn" onclick="previousStep()"
                            class="hidden px-4 py-2 bg-gray-200 rounded">
                        Kembali
                    </button>
                    <button type="button" id="nextBtn" onclick="nextStep()"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Lanjut
                    </button>
                    <button type="submit" id="submitBtn"
                            class="hidden px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Booking Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let currentStep = 1;
let selectedTime = null;
let bookingData = {};

function openBookingModal(fieldId) {
    document.getElementById('field_id').value = fieldId;
    document.getElementById('bookingModal').classList.remove('hidden');
    loadAvailableTimes();
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.add('hidden');
    resetForm();
}

async function loadAvailableTimes() {
    const date = document.getElementById('booking_date').value;
    const fieldId = document.getElementById('field_id').value;

    console.log('Loading times for field:', fieldId); // Tambahkan ini untuk debugging

    if (!fieldId || !date) return;

    const response = await fetch(`/api/available-times/${fieldId}?date=${date}`);
    const data = await response.json();

    if (data.field_id == fieldId) {
        renderTimeSlots(data.available_slots);
    }
}

// Tambahkan event listener untuk perubahan field_id
document.getElementById('field_id').addEventListener('change', function() {
    if (document.getElementById('booking_date').value) {
        loadAvailableTimes();
    }
});

function renderTimeSlots(slots) {
    const container = document.getElementById('timeSlots');
    container.innerHTML = '';

    slots.forEach(slot => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'p-2 border rounded hover:bg-green-100';
        button.textContent = slot;
        button.onclick = () => selectTimeSlot(slot, button);
        container.appendChild(button);
    });
}

function selectTimeSlot(time, element) {
    selectedTime = time;
    document.querySelectorAll('#timeSlots button').forEach(btn => {
        btn.classList.remove('bg-green-600', 'text-white');
    });
    element.classList.add('bg-green-600', 'text-white');
}

function changeDuration(change) {
    const durationInput = document.getElementById('duration');
    let duration = parseInt(durationInput.value) + change;
    duration = Math.min(Math.max(duration, 1), 4);
    durationInput.value = duration;
}

function nextStep() {
    if(currentStep === 1) {
        if(!validateStep1()) return;
        updateConfirmationData();
        currentStep++;
        toggleSteps();
    }
}

function previousStep() {
    currentStep--;
    toggleSteps();
}

function toggleSteps() {
    document.getElementById('step1').classList.toggle('hidden');
    document.getElementById('step2').classList.toggle('hidden');
    document.getElementById('prevBtn').classList.toggle('hidden');
    document.getElementById('nextBtn').classList.toggle('hidden');
    document.getElementById('submitBtn').classList.toggle('hidden');
}

function validateStep1() {
    if(!selectedTime || !document.getElementById('booking_date').value) {
        alert('Silakan pilih tanggal dan waktu terlebih dahulu');
        return false;
    }
    return true;
}

function updateConfirmationData() {
    const duration = parseInt(document.getElementById('duration').value);
    const price = duration * {{ $field->price_per_hour }};

    document.getElementById('confirmDate').textContent =
        document.getElementById('booking_date').value;
    document.getElementById('confirmTime').textContent =
        `${selectedTime} - ${calculateEndTime(selectedTime, duration)}`;
    document.getElementById('confirmDuration').textContent = `${duration} Jam`;
    document.getElementById('confirmPrice').textContent =
        `Rp${price.toLocaleString('id-ID')}`;

    bookingData = {
        field_id: {{ $field->id }},
        booking_date: document.getElementById('booking_date').value,
        start_time: selectedTime,
        duration: duration,
        total_price: price
    };
}

function calculateEndTime(start, duration) {
    const [hours, minutes] = start.split(':').map(Number);
    const end = new Date();
    end.setHours(hours + duration, minutes);
    return end.toTimeString().substring(0,5);
}
// Tambahkan event listener untuk perubahan metode pembayaran
document.getElementById('payment_method').addEventListener('change', function() {
    const submitBtn = document.getElementById('submitBtn');
    if(this.value === 'e-wallet') {
        submitBtn.textContent = 'Lanjutkan Pembayaran';
    } else {
        submitBtn.textContent = 'Booking Sekarang';
    }
});

async function submitBooking(e) {
    e.preventDefault();

    const formData = {
        field_id: bookingData.field_id,
        booking_date: bookingData.booking_date,
        start_time: bookingData.start_time,
        duration: bookingData.duration,
        payment_method: document.getElementById('payment_method').value
    };

    try {
        const response = await fetch('{{ route("user.bookings.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        
        // Jika response tidak sukses
        if (!response.ok) {
            throw new Error(data.message || 'Terjadi kesalahan sistem');
        }

        if (data.snap_token) {
            // Buka popup Midtrans
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    window.location.href = '{{ route("user.callback") }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route("user.callback") }}';
                },
                onError: function(result) {
                    Swal.fire('Error!', 'Pembayaran gagal', 'error');
                }
            });
        } else {
            Swal.fire('Success!', data.message, 'success');
            closeBookingModal();
        }
    } catch (error) {
        console.error('Booking Error:', error);
        Swal.fire('Error!', error.message || 'Terjadi kesalahan sistem', 'error');
    }
}

function resetForm() {
    currentStep = 1;
    selectedTime = null;
    bookingData = {};
    document.getElementById('bookingForm').reset();
    document.getElementById('step1').classList.remove('hidden');
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('prevBtn').classList.add('hidden');
    document.getElementById('nextBtn').classList.remove('hidden');
    document.getElementById('submitBtn').classList.add('hidden');
}

// Inisialisasi date picker
document.getElementById('booking_date').addEventListener('change', loadAvailableTimes);
</script>

<!-- Di akhir file booking.blade.php -->
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
