<?php
// app/Services/SiswaService.php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiswaService
{
    public function create(array $data): User
    {
        return User::create([
            'nis'           => $data['nis'],
            'name'          => $data['nama'],
            'email'         => $data['email'],
            'kelas_id'      => $data['kelas_id'],
            'alamat'        => $data['alamat'] ?? null,
            'nama_orangtua' => $data['nama_orangtua'] ?? null,
            'password'      => Hash::make($data['nis']),
            'role'          => 'siswa',
            'remember_token' => Str::random(10),
        ]);
    }

    public function update(User $user, array $data): User
    {
        // update data utama
        $user->update([
            'nis' => $data['nis'],
            'email' => $data['email'],
            'name' => $data['name'],
            'kelas_id' => $data['kelas_id'],
            'alamat' => $data['alamat'] ?? null,
            'nama_orangtua' => $data['nama_orangtua'] ?? null,
        ]);

        // update password jika diisi
        if (!empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
