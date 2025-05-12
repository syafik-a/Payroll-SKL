<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Karyawan User
        $userKaryawan = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        // Create Karyawan data for the karyawan user
        Karyawan::create([
            'user_id' => $userKaryawan->id,
            'nik' => '12345678',
            'alamat' => 'Jl. Contoh No. 123',
            'no_telepon' => '08123456789',
            'posisi' => 'Staff IT',
            'tanggal_masuk' => '2023-01-01',
            'gaji_pokok' => 5000000,
        ]);

        // Create more sample karyawan
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Karyawan ' . $i,
                'email' => 'karyawan' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'karyawan',
            ]);

            Karyawan::create([
                'user_id' => $user->id,
                'nik' => '0000000' . $i,
                'alamat' => 'Alamat Karyawan ' . $i,
                'no_telepon' => '0812345678' . $i,
                'posisi' => 'Staff',
                'tanggal_masuk' => now()->subMonths(rand(1, 12)),
                'gaji_pokok' => rand(3000000, 7000000),
            ]);
        }
    }
}