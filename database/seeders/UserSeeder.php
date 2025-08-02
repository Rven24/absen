<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // * User Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // * User Biasa
        User::create([
            'name' => 'Penjaga',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('kerjadulu'),
            'role' => 'karyawan',
        ]);
    }
}
