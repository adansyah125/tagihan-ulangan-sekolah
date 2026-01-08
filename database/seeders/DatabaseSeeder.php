<?php

namespace Database\Seeders;

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
