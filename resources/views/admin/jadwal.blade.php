<section id="jadwal" class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Jadwal Booking Saya</h2>

        <!-- Filter Jadwal -->
        <div class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="date" class="p-2 border rounded-lg md:w-48">
            <select class="p-2 border rounded-lg md:w-48">
                <option value="">Semua Status</option>
                <option>Upcoming</option>
                <option>Selesai</option>
                <option>Dibatalkan</option>
            </select>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                Filter
            </button>
        </div>

        <!-- Tabel Jadwal -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full">
                <thead class="bg-green-50">
                    <tr>
                        <th class="p-4 text-left">Lapangan</th>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-left">Waktu</th>
                        <th class="p-4 text-left">Durasi</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Item Jadwal 1 -->
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 font-semibold">Lapangan 1</td>
                        <td class="p-4">15 Juni 2024</td>
                        <td class="p-4">16:00 - 18:00</td>
                        <td class="p-4">2 Jam</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm">
                                Terkonfirmasi
                            </span>
                        </td>
                        <td class="p-4">
                            <button class="text-green-600 hover:text-green-700 mr-2">
                                <i class='bx bx-info-circle text-xl'></i>
                            </button>
                            <button class="text-red-600 hover:text-red-700">
                                <i class='bx bx-trash text-xl'></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Item Jadwal 2 -->
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 font-semibold">Lapangan 2</td>
                        <td class="p-4">20 Juni 2024</td>
                        <td class="p-4">19:00 - 21:00</td>
                        <td class="p-4">2 Jam</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm">
                                Menunggu Pembayaran
                            </span>
                        </td>
                        <td class="p-4">
                            <button class="text-green-600 hover:text-green-700 mr-2">
                                <i class='bx bx-credit-card text-xl'></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Item Jadwal 3 -->
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 font-semibold">Lapangan 1</td>
                        <td class="p-4">10 Juni 2024</td>
                        <td class="p-4">14:00 - 15:00</td>
                        <td class="p-4">1 Jam</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">
                                Selesai
                            </span>
                        </td>
                        <td class="p-4">
                            <button class="text-green-600 hover:text-green-700">
                                <i class='bx bx-star text-xl'></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div class="text-center py-12 hidden" id="empty-state">
            <i class='bx bx-calendar-x text-6xl text-gray-300 mb-4'></i>
            <p class="text-gray-500">Belum ada jadwal booking</p>
        </div>
    </div>
</section>
