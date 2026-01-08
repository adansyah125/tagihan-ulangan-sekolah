@extends('admin.layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-200">
                Detail Data Siswa
            </h1>

            <a href="{{ route('admin.siswa') }}"
                class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg text-gray-200 transition">
                ← Kembali
            </a>
        </div>

        <!-- Card -->
        <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-xl p-6 space-y-8">

            <!-- 🧑 Data Akun -->
            <div>
                <h3 class="text-sm font-semibold text-indigo-400 mb-4">
                    Data Akun
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="field">
                        <span>NIS</span>
                        <p>{{ $user->nis }}</p>
                    </div>
                    <div class="field">
                        <span>Email</span>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- 🎓 Data Siswa -->
            <div>
                <h3 class="text-sm font-semibold text-indigo-400 mb-4">
                    Data Siswa
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="field">
                        <span>Nama Siswa</span>
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="field">
                        <span>Kelas</span>
                        <p>{{ $user->kelas }}</p>
                    </div>

                    <div class="md:col-span-2 field">
                        <span>Alamat</span>
                        <p>{{ $user->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- 👪 Data Orang Tua -->
            <div>
                <h3 class="text-sm font-semibold text-indigo-400 mb-4">
                    Data Orang Tua
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="field">
                        <span>Nama Orang Tua</span>
                        <p>{{ $user->nama_orangtua ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
                <button onclick="document.getElementById('form-edit').scrollIntoView({ behavior: 'smooth' })"
                    class="bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl text-white transition">
                    Edit Data Siswa
                </button>
            </div>

        </div>
    </div>
    {{-- ================= FORM EDIT SISWA ================= --}}
    <div id="form-edit" class="bg-gray-900 border border-gray-700 rounded-2xl shadow-xl p-6 mt-8">

        <h3 class="text-lg font-bold text-indigo-400 mb-6">
            Edit Data Siswa
        </h3>

        <form action="{{ route('admin.siswa.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- NIS -->
                <div>
                    <label class="text-sm text-gray-400">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $user->nis) }}"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                    text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Email -->
                <div>
                    <label class="text-sm text-gray-400">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                    text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Nama -->
                <div>
                    <label class="text-sm text-gray-400">Nama Siswa</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                    text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Kelas -->
                <div>
                    <label class="text-sm text-gray-400">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                    text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

            </div>

            <!-- Alamat -->
            <div>
                <label class="text-sm text-gray-400">Alamat</label>
                <textarea name="alamat" rows="3"
                    class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <!-- Orang Tua -->
            <div>
                <label class="text-sm text-gray-400">Nama Orang Tua</label>
                <input type="text" name="nama_orangtua" value="{{ old('nama_orangtua', $user->nama_orangtua) }}"
                    class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
                <a href="{{ route('admin.siswa') }}" class="bg-gray-700 hover:bg-gray-600 px-5 py-2 rounded-xl text-white">
                    Batal
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 px-6 py-2 rounded-xl text-white font-semibold">
                    Update Data
                </button>
            </div>

        </form>
    </div>
@endsection
