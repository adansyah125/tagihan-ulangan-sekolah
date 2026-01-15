@extends('admin.layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="bg-gray-800/60 backdrop-blur-xl text-gray-100 rounded-2xl p-6 shadow-2xl border border-gray-700">
        {{-- Header --}}

        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4 bg-gray-800/20 p-4 rounded-2xl border border-gray-700/50 backdrop-blur-md">

            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-indigo-600/10 rounded-xl border border-indigo-500/20 shadow-inner">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-indigo-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>

                </div>

                <div>
                    <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">
                        Manajemen Siswa
                    </h2>
                    <p class="text-xs text-gray-500 font-medium">Manajemen Data Siswa</p>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <form method="GET">
                    <input type="text" id="searchInput" placeholder="Cari nama atau NIS..."
                        value="{{ request('search') }}" name="search"
                        class="bg-gray-900/60 text-gray-100 border border-gray-700 rounded-xl px-4 py-2 w-full md:w-64
                focus:ring-2 focus:ring-gray-500 focus:outline-none placeholder-gray-500">
                </form>

                <button onclick="openModal()"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl text-white font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Siswa
                </button>
            </div>


        </div>
        {{-- Success Alert --}}
        @if (session('success'))
            <div class="p-4 rounded-lg bg-green-50 border border-green-200 mb-2 dark:bg-green-900/30 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-green-800 dark:text-green-200 font-medium">Berhasil! Penambahan data telah disimpan.</p>
                </div>
            </div>
        @endif

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-hidden rounded-2xl border border-gray-700 bg-gray-900/50 shadow-xl">
            <table class="min-w-full text-sm text-left" id="dataTable">
                <thead class="bg-gray-800/80 text-gray-400 uppercase text-[11px] font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4 w-12">No</th>
                        <th class="px-6 py-4">Informasi Siswa</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Kontak & Alamat</th>
                        <th class="px-6 py-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800" id="siswaTable">
                    @forelse ($data as $item)
                        <tr class="hover:bg-indigo-600/5 transition-colors group">
                            {{-- Nomor --}}
                            <td class="px-6 py-4 text-gray-500 font-medium">
                                {{ $loop->iteration }}
                            </td>

                            {{-- Info Utama --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-full bg-indigo-600/20 flex items-center justify-center text-indigo-400 font-bold border border-indigo-500/20 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                        {{ substr($item->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-100">{{ $item->name }}</div>
                                        <div class="text-[11px] text-gray-500 font-mono tracking-tighter">NIS:
                                            {{ $item->nis }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kelas --}}
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-md bg-gray-800 text-gray-300 border border-gray-700 text-xs font-semibold">
                                    {{ $item->kelas->kelas }}
                                </span>
                            </td>

                            {{-- Detail Alamat & Ortu --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-300 italic">
                                        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                stroke-width="2" />
                                        </svg>
                                        {{ $item->nama_orangtua }}
                                    </div>
                                    <div class="text-[11px] text-gray-500 truncate max-w-[200px]">
                                        {{ $item->alamat }}
                                    </div>
                                </div>
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-3">
                                    {{-- View Detail --}}
                                    <a href="{{ route('admin.siswa.show', $item->id) }}"
                                        class="p-2 rounded-xl bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white transition-all shadow-sm"
                                        title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="h-4.5 w-4.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau hapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="p-2 rounded-xl bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="h-4.5 w-4.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 opacity-20 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                            stroke-width="2" />
                                    </svg>
                                    <p class="text-sm">Tidak ada data siswa ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-10 px-2 flex justify-center">
            <div class="w-full md:w-auto">
                {{ $data->links('pagination::tailwind') }}
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="md:hidden space-y-4 px-1">
            @forelse ($data as $item)
                <div
                    class="bg-gray-900/80 backdrop-blur-md rounded-3xl p-5 border border-gray-800 shadow-xl relative overflow-hidden group active:scale-[0.98] transition-all">

                    {{-- Badge NIS di pojok --}}
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-2xl bg-indigo-600/20 flex items-center justify-center text-indigo-400 font-bold border border-indigo-500/20">
                                {{ substr($item->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white leading-tight">{{ $item->name }}</h3>
                                <span class="text-[10px] font-mono text-gray-500 uppercase tracking-tighter">NIS:
                                    {{ $item->nis }}</span>
                            </div>
                        </div>
                        <span
                            class="px-2 py-1 rounded-lg bg-gray-800 text-gray-400 text-[10px] font-bold border border-gray-700">
                            {{ $item->kelas->kelas }}
                        </span>
                    </div>

                    {{-- Info Content --}}
                    <div class="space-y-2 mb-5">
                        <div class="flex items-start gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    stroke-width="2" />
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" />
                            </svg>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                {{ $item->alamat }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    stroke-width="2" />
                            </svg>
                            <span class="text-xs truncate italic">{{ $item->email }}</span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-800">
                        <a href="{{ route('admin.siswa.show', $item->id) }}"
                            class="flex items-center justify-center gap-2 bg-amber-500/10 hover:bg-amber-500 text-amber-500 hover:text-white py-2.5 rounded-xl text-xs font-bold transition-all uppercase tracking-wider shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    stroke-width="2" />
                            </svg>
                            Detail
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Hapus data siswa ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button
                                class="w-full flex items-center justify-center gap-2 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white py-2.5 rounded-xl text-xs font-bold transition-all uppercase tracking-wider shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        stroke-width="2" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-gray-900/50 rounded-3xl border border-dashed border-gray-800">
                    <p class="text-gray-500 text-sm italic">Tidak ada data siswa ditemukan</p>
                </div>
            @endforelse
        </div>


    </div>

    <!-- MODAL -->
    <div id="siswaModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">

        <div
            class="bg-gray-900 w-full max-w-3xl rounded-2xl shadow-2xl border border-gray-700 flex flex-col max-h-full animate-scale">

            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700 shrink-0">
                <h3 class="text-lg font-bold text-gray-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    </svg>
                    Form Data Siswa
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-400 p-2 transition">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.siswa.store') }}" method="POST"
                class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">
                @csrf
                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="p-1.5 bg-indigo-500/10 rounded-lg text-indigo-400 text-xs">01</span>
                        <h4 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider">Data Akun</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 ml-1">NIS</label>
                            <input type="number" name="nis" required
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white transition placeholder:text-gray-600"
                                placeholder="Contoh: 2024001">
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 ml-1">Email</label>
                            <input type="email" name="email" required
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white transition placeholder:text-gray-600"
                                placeholder="siswa@sekolah.com">
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="p-1.5 bg-indigo-500/10 rounded-lg text-indigo-400 text-xs">02</span>
                        <h4 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider">Data Siswa</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 ml-1">No Whatsapp</label>
                            <input type="number" name="telp" required
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white transition"
                                placeholder="No WhatsApp">
                        </div>


                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 ml-1">Kelas</label>
                            <div class="relative">
                                <select name="kelas_id" required
                                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white appearance-none cursor-pointer transition">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    @foreach ($kelas as $data)
                                        <option value="{{ $data->id }}">{{ $data->kelas }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-xs font-medium text-gray-500 ml-1">Nama Lengkap</label>
                            <input type="text" name="nama" required
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white transition"
                                placeholder="Nama Lengkap">
                        </div>

                        <div class="md:col-span-2 space-y-1">
                            <label class="text-xs font-medium text-gray-500 ml-1">Alamat</label>
                            <textarea name="alamat" rows="3"
                                class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white transition resize-none"
                                placeholder="Alamat lengkap tempat tinggal..."></textarea>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="p-1.5 bg-indigo-500/10 rounded-lg text-indigo-400 text-xs">03</span>
                        <h4 class="text-sm font-semibold text-indigo-400 uppercase tracking-wider">Data Orang Tua</h4>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 ml-1">Nama Orang Tua/Wali</label>
                        <input type="text" name="nama_orangtua" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none text-white transition"
                            placeholder="Nama Ayah/Ibu/Wali">
                    </div>
                </section>
                <div
                    class="flex justify-end gap-3 px-6 py-4 border-t border-gray-700 bg-gray-900/50 rounded-b-2xl shrink-0">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 transition text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition text-sm shadow-lg shadow-indigo-500/20">
                        Simpan Data
                    </button>
                </div>
            </form>


        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 10px;
        }
    </style>

    <script>
        function openModal() {
            document.getElementById('siswaModal').classList.remove('hidden')
            document.getElementById('siswaModal').classList.add('flex')
        }

        function closeModal() {
            document.getElementById('siswaModal').classList.add('hidden')
            document.getElementById('siswaModal').classList.remove('flex')
        }
    </script>





@endsection
