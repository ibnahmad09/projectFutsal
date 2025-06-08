<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Field;
use App\Models\FieldImage;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::create([
            'name' => 'Lapangan Utama',
            'description' => 'Lapangan futsal utama dengan kualitas terbaik',
            'price_per_hour' => 80000,
            'open_time' => '08:00:00',
            'close_time' => '22:00:00'
        ]);

        // Tambahkan gambar lapangan
        FieldImage::create([
            'field_id' => 1,
            'image_path' => 'field_images/3bx51Vzc9oh6bRXoKm9rMNZMCFbUZHa9MX6vD7BE.png'
        ]);
    }
}
