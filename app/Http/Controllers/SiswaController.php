<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SiswaService;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Kelas;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $data = User::latest()->where('role', 'siswa')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('nis', 'like', "%$search%");
            })
            ->paginate(10);
        $kelas = Kelas::all();
        return view('admin.siswa', compact('data', 'kelas'));
    }

    public function store(StoreSiswaRequest $request, SiswaService $service)
    {
        $service->create($request->validated());

        return back()->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $kelas = Kelas::all();
        return view('admin.show-siswa', compact('user', 'kelas'));
    }

    public function update(UpdateSiswaRequest $request, User $user, SiswaService $siswaService)
    {
        if ($user->role !== 'siswa') {
            abort(403);
        }

        $siswaService->update($user, $request->validated());

        return redirect()
            ->route('admin.siswa.show', $user->id)
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(User $user, SiswaService $service)
    {
        $service->delete($user);

        return back()->with('success', 'Data siswa berhasil dihapus');
    }
}
