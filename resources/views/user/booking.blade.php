<!-- Tambahkan di bagian bawah sebelum </body> -->
<div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Header Modal -->
        <div class="p-6 border-b flex justify-between items-center">
            <h3 class="text-2xl font-bold">Booking Lapangan</h3>
            <button onclick="closeBookingModal()" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="p-6">
            <!-- Step 1 - Pilih Jadwal -->
            <div id="step1" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-2 font-medium">Tanggal Booking</label>
                        <input type="date" id="bookingDate"
                               class="w-full p-2 border rounded-lg"
                               min="<?= date('Y-m-d') ?>">
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">Durasi (Jam)</label>
                        <select id="duration" class="w-full p-2 border rounded-lg">
                            <option value="1">1 Jam</option>
                            <option value="2">2 Jam</option>
                            <option value="3">3 Jam</option>
                        </select>
                    </div>
                </div>

                <!-- Time Slot Grid -->
                <div>
                    <h4 class="font-medium mb-4">Pilih Jam Mulai</h4>
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-2" id="timeSlots">
                        <!-- Time slots akan diisi via JavaScript -->
                        <div class="p-2 text-center border rounded-lg bg-gray-100 cursor-not-allowed">
                            08:00 <span class="text-xs text-red-500">(Booked)</span>
                        </div>
                        <div class="p-2 text-center border rounded-lg bg-green-100 hover:bg-green-200 cursor-pointer">
                            09:00
                        </div>
                        <!-- Tambahkan lebih banyak slot -->
                    </div>
                </div>
            </div>

            <!-- Step 2 - Konfirmasi & Bayar -->
            <div id="step2" class="hidden space-y-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span>Lapangan:</span>
                        <span class="font-semibold">Lapangan 1</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Tanggal:</span>
                        <span class="font-semibold" id="confirmDate">-</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Waktu:</span>
                        <span class="font-semibold" id="confirmTime">-</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Durasi:</span>
                        <span class="font-semibold" id="confirmDuration">-</span>
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total:</span>
                        <span id="totalPrice">Rp120,000</span>
                    </div>
                </div>

                <!-- Pilih Metode Pembayaran -->
                <div>
                    <h4 class="font-medium mb-4">Metode Pembayaran</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 border rounded-lg cursor-pointer hover:border-green-500 payment-method">
                            <div class="flex items-center">
                                <i class='bx bx-credit-card text-xl mr-2'></i>
                                Kartu Kredit
                            </div>
                        </div>
                        <div class="p-3 border rounded-lg cursor-pointer hover:border-green-500 payment-method">
                            <div class="flex items-center">
                                <i class='bx bx-wallet text-xl mr-2'></i>
                                E-Wallet
                            </div>
                        </div>
                        <div class="p-3 border rounded-lg cursor-pointer hover:border-green-500 payment-method">
                            <div class="flex items-center">
                                <i class='bx bx-bank text-xl mr-2'></i>
                                Transfer Bank
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between mt-8">
                <button onclick="previousStep()"
                        id="prevBtn"
                        class="hidden px-6 py-2 text-gray-600 hover:text-gray-800">
                    <i class='bx bx-chevron-left mr-2'></i>Kembali
                </button>
                <button onclick="nextStep()"
                        id="nextBtn"
                        class="ml-auto bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Lanjut ke Pembayaran <i class='bx bx-chevron-right ml-2'></i>
                </button>
                <button id="confirmBtn"
                        class="hidden ml-auto bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Konfirmasi Booking
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    let selectedTime = null;
    let selectedPayment = null;

    function openBookingModal() {
        document.getElementById('bookingModal').classList.remove('hidden');
        generateTimeSlots();
    }

    function closeBookingModal() {
        document.getElementById('bookingModal').classList.add('hidden');
        resetForm();
    }

    function generateTimeSlots() {
        const container = document.getElementById('timeSlots');
        container.innerHTML = '';

        // Contoh data dummy
        const timeSlots = [
            { time: '08:00', available: false },
            { time: '09:00', available: true },
            { time: '10:00', available: true },
            // ... tambahkan lebih banyak slot
        ];

        timeSlots.forEach(slot => {
            const div = document.createElement('div');
            div.className = `p-2 text-center border rounded-lg cursor-pointer ${
                slot.available ?
                'bg-green-100 hover:bg-green-200' :
                'bg-gray-100 cursor-not-allowed'
            }`;
            div.innerHTML = slot.time + (!slot.available ? ' <span class="text-xs text-red-500">(Booked)</span>' : '');

            if(slot.available) {
                div.addEventListener('click', () => {
                    document.querySelectorAll('#timeSlots > div').forEach(el => {
                        el.classList.remove('bg-green-300', 'border-green-500');
                    });
                    div.classList.add('bg-green-300', 'border-green-500');
                    selectedTime = slot.time;
                });
            }

            container.appendChild(div);
        });
    }

    function updateSummary() {
        document.getElementById('confirmDate').textContent =
            document.getElementById('bookingDate').value;

        document.getElementById('confirmTime').textContent = selectedTime;

        document.getElementById('confirmDuration').textContent =
            document.getElementById('duration').value + ' Jam';

        // Hitung total harga
        const pricePerHour = 120000; // Ambil dari database
        const total = pricePerHour * document.getElementById('duration').value;
        document.getElementById('totalPrice').textContent =
            'Rp' + total.toLocaleString('id-ID');
    }

    function nextStep() {
        if(currentStep === 1) {
            // Validasi step 1
            if(!selectedTime || !document.getElementById('bookingDate').value) {
                alert('Silakan pilih tanggal dan jam terlebih dahulu!');
                return;
            }

            updateSummary();
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            document.getElementById('prevBtn').classList.remove('hidden');
            document.getElementById('nextBtn').classList.add('hidden');
            document.getElementById('confirmBtn').classList.remove('hidden');
            currentStep = 2;
        }
    }

    function previousStep() {
        if(currentStep === 2) {
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('prevBtn').classList.add('hidden');
            document.getElementById('nextBtn').classList.remove('hidden');
            document.getElementById('confirmBtn').classList.add('hidden');
            currentStep = 1;
        }
    }

    function resetForm() {
        currentStep = 1;
        selectedTime = null;
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('prevBtn').classList.add('hidden');
        document.getElementById('nextBtn').classList.remove('hidden');
        document.getElementById('confirmBtn').classList.add('hidden');
    }

    // Event Listeners
    document.querySelectorAll('.payment-method').forEach(el => {
        el.addEventListener('click', function() {
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('border-green-500', 'bg-green-50');
            });
            this.classList.add('border-green-500', 'bg-green-50');
            selectedPayment = this.querySelector('div').textContent.trim();
        });
    });

    // Update tombol booking di card lapangan
    document.querySelectorAll('button:contains("Booking")').forEach(btn => {
        btn.addEventListener('click', openBookingModal);
    });
</script>

