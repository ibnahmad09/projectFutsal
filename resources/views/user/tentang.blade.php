
    @extends('layouts.user')

    @section('title','Tentang Kami')


    @section('content')<!-- Hero Section -->

 <div class="pt-20 pb-24 bg-gradient-to-r from-green-600 to-green-800">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">FUTSALDESA</h1>
        <p class="text-xl text-green-100 max-w-3xl mx-auto">
            Platform Penyewaan Lapangan Futsal Modern untuk Kemajuan Olahraga Desa
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Tentang Kami -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
        <div class="order-2 lg:order-1">
            <h2 class="text-3xl font-bold mb-6">Siapa Kami?</h2>
            <p class="text-gray-600 mb-4">
                FUTSALDESA merupakan inisiatif pemuda desa untuk memodernisasi sistem penyewaan lapangan futsal.
                Didirikan pada 2023, kami bertujuan meningkatkan minat olahraga sekaligus mengelola fasilitas olahraga
                desa secara profesional.
            </p>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">500+</div>
                    <div class="text-gray-600">Pengguna Terdaftar</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">24/7</div>
                    <div class="text-gray-600">Layanan Online</div>
                </div>
            </div>
        </div>
        <div class="order-1 lg:order-2">
            <img src="https://source.unsplash.com/random/800x600?futsal-team"
                 alt="Tim Kami"
                 class="rounded-xl shadow-xl">
        </div>
    </div>

    <!-- Visi Misi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-600">
            <h3 class="text-2xl font-bold mb-4 flex items-center">
                <i class='bx bx-target-lock text-green-600 mr-2'></i>
                Visi
            </h3>
            <p class="text-gray-600">
                Menjadi platform pengelolaan lapangan futsal desa terdepan yang mendukung pengembangan bakat
                olahraga dan pemberdayaan ekonomi kreatif pemuda desa.
            </p>
        </div>
        <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-600">
            <h3 class="text-2xl font-bold mb-4 flex items-center">
                <i class='bx bx-planet text-green-600 mr-2'></i>
                Misi
            </h3>
            <ul class="list-disc list-inside text-gray-600 space-y-2">
                <li>Menyediakan sistem manajemen lapangan modern</li>
                <li>Meningkatkan partisipasi olahraga masyarakat</li>
                <li>Mengembangkan ekonomi kreatif berbasis olahraga</li>
            </ul>
        </div>
    </div>

    <!-- Tim -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-8">Tim Kami</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-md text-center">
                <img src="https://source.unsplash.com/random/400x400?person1"
                     alt="Team Member"
                     class="w-32 h-32 rounded-full mx-auto mb-4">
                <h4 class="text-xl font-bold mb-2">Ahmad Surya</h4>
                <p class="text-green-600 mb-2">Founder & CEO</p>
                <p class="text-gray-600 text-sm">"Bersama kita bangun desa melalui olahraga"</p>
            </div>
            <!-- Tambahkan anggota tim lainnya -->
        </div>
    </div>

    <!-- Peta Lokasi -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-16">
        <h2 class="text-3xl font-bold mb-6 text-center">Lokasi Lapangan</h2>
        <div class="aspect-w-16 aspect-h-9">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126646.25766508106!2d112.63027829453124!3d-7.2757699999999945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbf8381ac47f%3A0x3027a76e352be40!2sSurabaya%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1718285541354!5m2!1sid!2sid"
                class="w-full h-96 rounded-lg border-0"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>

    <!-- Kontak -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-xl shadow-md">
            <h2 class="text-3xl font-bold mb-6">Hubungi Kami</h2>
            <form class="space-y-4">
                <div>
                    <label class="block mb-2">Nama Lengkap</label>
                    <input type="text" class="w-full p-2 border rounded-lg">
                </div>
                <div>
                    <label class="block mb-2">Email</label>
                    <input type="email" class="w-full p-2 border rounded-lg">
                </div>
                <div>
                    <label class="block mb-2">Pesan</label>
                    <textarea rows="4" class="w-full p-2 border rounded-lg"></textarea>
                </div>
                <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Kirim Pesan
                </button>
            </form>
        </div>
        <div class="space-y-6">
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-4">Informasi Kontak</h3>
                <ul class="space-y-3">
                    <li class="flex items-center">
                        <i class='bx bx-map text-green-600 mr-2'></i>
                        Jl. Olahraga No. 123, Desa Sportif, Jawa Timur
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-phone text-green-600 mr-2'></i>
                        +62 812-3456-7890
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-envelope text-green-600 mr-2'></i>
                        info@futsaldesa.id
                    </li>
                </ul>
            </div>
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-bold mb-4">Jam Operasional</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between">
                        <span>Senin-Jumat</span>
                        <span>08:00 - 22:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sabtu-Minggu</span>
                        <span>07:00 - 23:00</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
