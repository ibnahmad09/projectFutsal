<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking - FUTSALDESA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navbar (Sama seperti sebelumnya) -->

    <!-- Header Section -->
    <div class="pt-20 pb-12 bg-green-700">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Riwayat Booking</h1>
                <p class="text-lg">Lihat dan kelola riwayat pemesanan lapangan Anda</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Filter Section -->
        <div class="mb-6 bg-white p-4 rounded-lg shadow-md">
            <div class="flex flex-col md:flex-row gap-4">
                <input type="date" class="p-2 border rounded-lg flex-1">
                <select class="p-2 border rounded-lg flex-1">
                    <option value="">Semua Status</option>
                    <option>Berhasil</option>
                    <option>Pending</option>
                    <option>Dibatalkan</option>
                    <option>Selesai</option>
                </select>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Filter
                </button>
                <button class="bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200 transition flex items-center">
                    <i class='bx bx-download mr-2'></i>Export
                </button>
            </div>
        </div>

        <!-- Riwayat List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block">
                <div class="bg-green-50 grid grid-cols-12 gap-4 p-4 font-semibold">
                    <div class="col-span-3">Lapangan</div>
                    <div class="col-span-2">Tanggal</div>
                    <div class="col-span-2">Waktu</div>
                    <div class="col-span-2">Status</div>
                    <div class="col-span-2">Total</div>
                    <div class="col-span-1">Aksi</div>
                </div>

                <!-- Booking Item 1 -->
                <div class="grid grid-cols-12 gap-4 p-4 border-b hover:bg-gray-50 transition">
                    <div class="col-span-3 font-semibold flex items-center">
                        <img src="https://source.unsplash.com/random/100x100?futsal"
                             class="w-12 h-12 rounded-lg mr-3 object-cover">
                        Lapangan Utama
                    </div>
                    <div class="col-span-2 flex items-center">
                        <i class='bx bx-calendar mr-2 text-gray-600'></i>15 Jun 2024
                    </div>
                    <div class="col-span-2 flex items-center">
                        <i class='bx bx-time mr-2 text-gray-600'></i>16:00 - 18:00
                    </div>
                    <div class="col-span-2">
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">
                            <i class='bx bx-check-circle mr-1'></i>Berhasil
                        </span>
                    </div>
                    <div class="col-span-2 font-semibold text-green-600">
                        Rp240.000
                    </div>
                    <div class="col-span-1 flex items-center space-x-2">
                        <button class="text-green-600 hover:text-green-700">
                            <i class='bx bx-info-circle text-xl'></i>
                        </button>
                        <button class="text-red-600 hover:text-red-700">
                            <i class='bx bx-trash text-xl'></i>
                        </button>
                    </div>
                </div>

                <!-- Booking Item 2 -->
                <div class="grid grid-cols-12 gap-4 p-4 border-b hover:bg-gray-50 transition">
                    <div class="col-span-3 font-semibold flex items-center">
                        <img src="https://source.unsplash.com/random/100x100?futsal2"
                             class="w-12 h-12 rounded-lg mr-3 object-cover">
                        Lapangan Indoor
                    </div>
                    <div class="col-span-2 flex items-center">
                        <i class='bx bx-calendar mr-2 text-gray-600'></i>20 Jun 2024
                    </div>
                    <div class="col-span-2 flex items-center">
                        <i class='bx bx-time mr-2 text-gray-600'></i>19:00 - 21:00
                    </div>
                    <div class="col-span-2">
                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm">
                            <i class='bx bx-time-five mr-1'></i>Pending
                        </span>
                    </div>
                    <div class="col-span-2 font-semibold text-gray-600">
                        Rp240.000
                    </div>
                    <div class="col-span-1 flex items-center space-x-2">
                        <button class="text-green-600 hover:text-green-700">
                            <i class='bx bx-credit-card text-xl'></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden">
                <!-- Booking Item 1 -->
                <div class="p-4 border-b">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center">
                            <img src="https://source.unsplash.com/random/100x100?futsal"
                                 class="w-12 h-12 rounded-lg mr-3 object-cover">
                            <div>
                                <h3 class="font-semibold">Lapangan Utama</h3>
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-sm">
                                    <i class='bx bx-check-circle mr-1'></i>Berhasil
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-green-600">
                                <i class='bx bx-info-circle text-xl'></i>
                            </button>
                            <button class="text-red-600">
                                <i class='bx bx-trash text-xl'></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center text-gray-600">
                            <i class='bx bx-calendar mr-2'></i>15 Jun 2024
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class='bx bx-time mr-2'></i>16:00 - 18:00
                        </div>
                        <div class="flex items-center text-green-600 font-semibold">
                            <i class='bx bx-wallet mr-2'></i>Rp240.000
                        </div>
                    </div>
                </div>

                <!-- Booking Item 2 -->
                <div class="p-4 border-b">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center">
                            <img src="https://source.unsplash.com/random/100x100?futsal2"
                                 class="w-12 h-12 rounded-lg mr-3 object-cover">
                            <div>
                                <h3 class="font-semibold">Lapangan Indoor</h3>
                                <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm">
                                    <i class='bx bx-time-five mr-1'></i>Pending
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-green-600">
                                <i class='bx bx-credit-card text-xl'></i>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center text-gray-600">
                            <i class='bx bx-calendar mr-2'></i>20 Jun 2024
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class='bx bx-time mr-2'></i>19:00 - 21:00
                        </div>
                        <div class="flex items-center text-gray-600 font-semibold">
                            <i class='bx bx-wallet mr-2'></i>Rp240.000
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div class="p-12 text-center text-gray-500 hidden" id="empty-history">
                <i class='bx bx-calendar-x text-6xl mb-4'></i>
                <p>Belum ada riwayat booking</p>
            </div>
        </div>
    </div>

    <!-- Footer (Sama seperti sebelumnya) -->

    <script>
        // Tambahkan fungsi untuk:
        // - Konfirmasi pembatalan
        // - Toggle empty state
        // - Filter riwayat
        // - Export data
    </script>
</body>
</html>
