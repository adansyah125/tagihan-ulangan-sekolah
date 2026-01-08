<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Data User Pertama
        User::create([
            'name' => 'syahdan',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nis' => 23110065,
            'kelas' => 'XII RPL 1',
            'alamat' => 'Jl. Kebon Jeruk No. 123',
            'nama_orangtua' => 'Bapak Syahdan',
        ]);

        // Data User Kedua
        User::create([
            'name' => 'Staf Administrasi',
            'email' => 'staf@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staf',
        ]);
    }
}
