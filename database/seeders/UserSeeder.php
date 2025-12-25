<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'rt_rw' => null,
        ]);

        // Petugas RT 001/RW 001
        User::create([
            'name' => 'Petugas RT 001',
            'email' => 'petugas001@example.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'rt_rw' => '001/001',
        ]);

        // Petugas RT 002/RW 001
        User::create([
            'name' => 'Petugas RT 002',
            'email' => 'petugas002@example.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'rt_rw' => '002/001',
        ]);

        // Petugas RT 003/RW 001
        User::create([
            'name' => 'Petugas RT 003',
            'email' => 'petugas003@example.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'rt_rw' => '003/001',
        ]);

        // Masyarakat (contoh)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'masyarakat',
            'rt_rw' => null,
        ]);
    }
}
