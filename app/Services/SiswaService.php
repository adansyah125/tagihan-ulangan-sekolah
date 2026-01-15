<?php
// app/Services/SiswaService.php

namespace App\Services;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SiswaService
{

    public function getSiswaList(?string $search)
    {
        return User::query()
            ->where('role', 'siswa')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function getKelasWithUser()
    {
        return Kelas::with('user')->get();
    }
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
            'telp'          => $data['telp'],
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
            'telp'          => $data['telp'],
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
