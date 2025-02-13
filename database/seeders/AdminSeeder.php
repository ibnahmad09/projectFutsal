<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'Admin Futsal',
        'email' => 'admin@futsaldesa.test',
        'password' => bcrypt('admin123'),
        'phone_number' => '6281234567890',
        'address' => 'Kantor Admin Futsal Desa',
        'role' => 'admin'
    ]);
}
}
