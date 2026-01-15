<?php

namespace Database\Seeders;

use App\Models\Kelas;
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
        Kelas::create([
            'kelas' => 'XII RPL 1',
        ]);
        Kelas::create([
            'kelas' => 'XII RPL 2    ',
        ]);
        Kelas::create([
            'kelas' => 'XII RPL 3',
        ]);
        // Data User Pertama
        $kelas_id = Kelas::first()->id;
        $nis = 23110064;
        User::create([
            'name' => 'Heri',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nis' => $nis,
            'kelas_id' => $kelas_id,
            'alamat' => 'Jl. Kebon Jeruk No. 123',
            'nama_orangtua' => 'Bapak Syahdan',
            'password' => Hash::make($nis),
            'telp' => '085922397664'
        ]);
        // Data User Kedua
        $nis2 = 23110065;

        User::create([
            'name' => 'syahdan',
            'email' => 'adansyah225@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'nis' => $nis2,
            'kelas_id' => $kelas_id,
            'alamat' => 'Jl. Kebon Jeruk No. 123',
            'nama_orangtua' => 'Bapak Syahdan',
            'password' => Hash::make($nis2),
            'telp' => '085750547204'
        ]);

        // Data User Kedua
        User::create([
            'name' => 'Staf Administrasi',
            'email' => 'staf@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'staf',
            'telp' => '0895364519064'
        ]);
    }
}
