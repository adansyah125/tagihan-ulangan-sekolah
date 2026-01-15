@extends('admin.layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-4 md:p-6">
        @if (session('success'))
            <div id="success-alert"
                class="p-4 rounded-lg bg-green-50 border border-green-200 mb-2 dark:bg-green-900/30 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-green-800 dark:text-green-200 font-medium">Berhasil! Perubahan anda telah disimpan.</p>
                </div>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Detail Siswa</h1>
                <p class="text-gray-400 text-sm mt-1">Manajemen informasi lengkap dan pembaruan data.</p>
            </div>
            <a href="{{ route('admin.siswa') }}"
                class="group flex items-center gap-2 bg-gray-800 hover:bg-gray-700 px-5 py-2.5 rounded-xl text-gray-300 transition-all border border-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden mb-10">
            <div class="p-8 space-y-10">
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-indigo-500/10 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-200">Informasi Akun</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                            <span class="text-xs font-semibold text-gray-500 uppercase">NIS</span>
                            <p class="text-white font-medium mt-1 text-lg">{{ $user->nis }}</p>
                        </div>
                        <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Alamat Email</span>
                            <p class="text-white font-medium mt-1 text-lg">{{ $user->email }}</p>
                        </div>
                        <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                            <span class="text-xs font-semibold text-gray-500 uppercase">No WhatsApp</span>
                            <p class="text-white font-medium mt-1 text-lg">{{ $user->telp }}</p>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-emerald-500/10 rounded-lg">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-200">Profil Akademik</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</span>
                            <p class="text-white font-medium mt-1 text-lg">{{ $user->name }}</p>
                        </div>
                        <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Kelas</span>
                            <p class="text-white font-medium mt-1 text-lg">{{ $user->kelas->kelas ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2 bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Alamat Tinggal</span>
                            <p class="text-white mt-1">{{ $user->alamat ?? 'Belum mengisi alamat' }}</p>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-amber-500/10 rounded-lg">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-200">Data Wali</h3>
                    </div>
                    <div class="bg-gray-800/40 p-4 rounded-2xl border border-gray-800">
                        <span class="text-xs font-semibold text-gray-500 uppercase">Nama Orang Tua / Wali</span>
                        <p class="text-white font-medium mt-1 text-lg">{{ $user->nama_orangtua ?? '-' }}</p>
                    </div>
                </section>

                <div class="flex justify-end pt-6">
                    <button onclick="document.getElementById('form-edit').scrollIntoView({ behavior: 'smooth' })"
                        class="group bg-indigo-600 hover:bg-indigo-500 px-8 py-3 rounded-2xl text-white font-bold transition-all shadow-lg shadow-indigo-500/25 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Data Siswa
                    </button>
                </div>
            </div>
        </div>

        {{-- ================= FORM EDIT SISWA ================= --}}
        <div id="form-edit"
            class="bg-gray-900 border border-indigo-500/30 rounded-3xl shadow-2xl p-8 mt-12 mb-20 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h3 class="text-2xl font-black text-white mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-sm">✎</span>
                    Form Pembaruan Data
                </h3>

                <form action="{{ route('admin.siswa.update', $user->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-400 ml-1">Nomor Induk Siswa (NIS)</label>
                            <input type="text" name="nis" value="{{ old('nis', $user->nis) }}"
                                class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-400 ml-1">Email Aktif</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-400 ml-1">No WhatsApp</label>
                            <input type="number" name="telp" value="{{ old('telp', $user->telp) }}"
                                class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-400 ml-1">Kelas</label>
                            <div class="relative">
                                <select name="kelas_id"
                                    class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}"
                                            {{ $user->kelas_id == $k->id ? 'selected' : '' }}>
                                            {{ $k->kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-400 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-400 ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3"
                            class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-400 ml-1">Nama Orang Tua / Wali</label>
                        <input type="text" name="nama_orangtua"
                            value="{{ old('nama_orangtua', $user->nama_orangtua) }}"
                            class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-400 ml-1">
                            Kata Sandi
                        </label>

                        <input type="text" name="password" placeholder="Ubah password (opsional)"
                            class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-3 text-white
               placeholder-gray-500 focus:ring-4 focus:ring-indigo-500/20
               focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="flex flex-col md:flex-row justify-end gap-4 pt-6 border-t border-gray-800">
                        <a href="{{ route('admin.siswa') }}"
                            class="px-8 py-3 rounded-2xl bg-gray-800 hover:bg-gray-700 text-white text-center font-medium transition-all">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-10 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition-all shadow-xl shadow-indigo-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce-in {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            70% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-bounce-in {
            animation: bounce-in 0.4s ease-out;
        }
    </style>

    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 3000);
    </script>
@endsection
