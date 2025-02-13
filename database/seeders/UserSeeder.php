<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\User::create([
        'name' => 'UserFutsal',
        'email' => 'user@gmail.test',
        'password' => bcrypt('user123'),
        'phone_number' => '6282226866782',
        'address' => 'Kantor Admin Futsal Desa',
        'role' => 'user'
    ]);
}
}
