@extends('admin.layouts.app')

@section('title', 'Tagihan UTS')

@section('content')
    <div class="bg-gray-900 text-gray-100 rounded-2xl p-6 shadow-lg">

        {{-- HEADER --}}
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4 bg-gray-800/20 p-4 rounded-2xl border border-gray-700/50 backdrop-blur-md">

            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-indigo-600/10 rounded-xl border border-indigo-500/20 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">
                        Manajemen Tagihan
                    </h2>
                    <p class="text-xs text-gray-500 font-medium">Manajemen periode tagihan ujian & harian</p>
                </div>
            </div>

            <button onclick="openModal()"
                class="group relative flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 px-6 py-3 rounded-xl text-white font-bold transition-all duration-300 active:scale-95 shadow-lg shadow-indigo-600/25 overflow-hidden">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700">
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-hover:rotate-90"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-sm tracking-wide">BUAT TAGIHAN BARU</span>
            </button>
        </div>

        {{--  DESKTOP TABLE --}}
        <div class="hidden md:block overflow-hidden rounded-2xl border border-gray-700 bg-gray-900 shadow-xl">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-800/50 text-gray-400 uppercase text-[11px] font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Jenis & Tahun Ajaran</th>
                        <th class="px-6 py-4">Nominal Tagihan</th>
                        <th class="px-6 py-4">Masa Berlaku</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-800/40 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-200">{{ $item->jenis_tagihan }}</div>
                                <div class="text-xs text-gray-500">{{ $item->tahun_ajaran }}</div>
                            </td>
                            <td class="px-6 py-4 font-bold text-indigo-400">
                                Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-gray-400">
                                <div class="flex items-center gap-2">
                                    <span>{{ \Carbon\Carbon::parse($item->tgl_tagihan)->format('d M Y') }}</span>
                                    <span class="text-gray-600">→</span>
                                    <span
                                        class="text-rose-400/80">{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status == 'Buka')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-tighter">
                                        ● Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-gray-700/50 text-gray-400 border border-gray-600 uppercase tracking-tighter">
                                        ● Tutup
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end items-center gap-2">
                                    {{-- Tombol Buat Tagihan --}}
                                    <button type="button" onclick="openAksesModal('{{ $item->id }}')"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-600/10 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all text-xs font-semibold ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Buat Tagihan
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('tagihan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus tagihan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 rounded-lg text-gray-500 hover:bg-rose-500/10 hover:text-rose-500 transition-all shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
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
                            <td class="px-6 py-10 text-center text-gray-500 italic" colspan="5">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 opacity-20" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Belum ada tagihan yang dibuat.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--  MOBILE CARD --}}
        <div class="md:hidden space-y-4 px-1">
            @forelse ($data as $item)
                <div class="bg-gray-900 border border-gray-700 rounded-2xl p-5 shadow-lg relative overflow-hidden group">

                    <div
                        class="absolute top-0 left-0 w-1.5 h-full {{ $item->status == 'Buka' ? 'bg-emerald-500' : 'bg-rose-500' }}">
                    </div>

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Tahun Ajaran</span>
                            <h3 class="font-black text-white text-lg leading-tight">{{ $item->tahun_ajaran }}</h3>
                        </div>

                        {{-- BADGE STATUS (Buka / Tutup) --}}
                        <span
                            class="text-[10px] font-bold px-3 py-1 rounded-full border 
                    {{ $item->status == 'Buka'
                        ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'
                        : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div class="space-y-1">
                            <span class="block text-[10px] text-gray-500 uppercase font-bold">Nominal</span>
                            <p class="text-indigo-300 font-bold text-sm">Rp
                                {{ number_format($item->nominal, 0, ',', '.') }}</p>
                        </div>
                        <div class="space-y-1 text-right">
                            <span class="block text-[10px] text-gray-500 uppercase font-bold">Jatuh Tempo</span>
                            <p class="text-gray-300 font-semibold text-sm">
                                {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <button onclick="openAksesModal('{{ $item->id }}')"
                            class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 py-3 rounded-xl text-white text-xs font-bold transition-all active:scale-95 shadow-lg shadow-indigo-600/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            BUAT TAGIHAN SISWA
                        </button>


                        <form action="{{ route('tagihan.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Hapus data tagihan ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="w-full flex items-center justify-center gap-2 border border-gray-800 hover:bg-rose-600/10 hover:border-rose-600 hover:text-rose-500 py-2.5 rounded-xl text-gray-500 text-[11px] font-medium transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Tagihan
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-gray-900/50 rounded-3xl border-2 border-dashed border-gray-800">
                    <p class="text-gray-500 text-sm font-medium">Belum ada tagihan</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- MODAL --}}
    <div id="modalUTS" class="fixed inset-0 hidden z-50 bg-black/70 backdrop-blur-sm items-center justify-center p-4">

        <div
            class="bg-gray-900 w-full max-w-lg rounded-2xl shadow-2xl border border-gray-700 flex flex-col max-h-[95vh] animate-scale">

            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700 shrink-0">
                <h3 class="text-lg font-bold text-indigo-400 flex items-center gap-2">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                    Buka Tagihan Baru
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-400 p-2 transition">
                    ✕
                </button>
            </div>

            <form class="p-6 space-y-5 overflow-y-auto flex-1 custom-scrollbar"
                action="{{ route('admin.tagihan.uts.store') }}" method="POST">
                @csrf

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-500 ml-1 uppercase">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" required
                        class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white
                    focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition placeholder:text-gray-600"
                        placeholder="Contoh: 2024/2025">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-500 ml-1 uppercase">Jenis Tagihan</label>
                    <div class="relative">
                        <select name="jenis_tagihan" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-700 bg-gray-800 text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Jenis</option>
                            <option value="UTS">UTS (Ujian Tengah Semester)</option>
                            <option value="UAS">UAS (Ujian Akhir Semester)</option>
                            <option value="Harian">Ulangan Harian</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-gray-500 ml-1 uppercase">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                        <input type="number" name="nominal" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl pl-11 pr-4 py-3 text-white
                        focus:ring-2 focus:ring-indigo-500 outline-none transition"
                            placeholder="0">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 ml-1 uppercase">Tanggal Mulai</label>
                        <input type="date" name="tgl_tagihan" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white
                        focus:ring-2 focus:ring-indigo-500 outline-none transition uppercase text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 ml-1 uppercase">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" required
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white
                        focus:ring-2 focus:ring-indigo-500 outline-none transition uppercase text-sm">
                    </div>
                </div>

                <div class="h-2"></div>
                <div
                    class="flex justify-end gap-3 px-6 py-4 border-t border-gray-700 bg-gray-900/50 rounded-b-2xl shrink-0">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 font-medium transition text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold transition text-sm shadow-lg shadow-indigo-500/20">
                        Simpan Tagihan
                    </button>
                </div>
            </form>


        </div>
    </div>
    {{-- MODAL AKSES TAGIHAN --}}
    <div id="modalAkses"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">

        <div
            class="bg-gray-900 border border-gray-700 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] animate-scale">

            <div class="p-5 flex items-center justify-between border-b border-gray-800 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                    <h3 class="text-lg font-bold text-white">Target Tagihan</h3>
                </div>
                <button type="button" onclick="closeAksesModal()"
                    class="text-gray-400 hover:text-red-400 p-2 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form id="formAkses" method="POST" class="overflow-y-auto flex-1 custom-scrollbar">
                @csrf
                <div class="p-6 space-y-6">

                    <div class="space-y-3">
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Pilih Jangkauan
                            Penerima:</label>

                        <label
                            class="relative flex items-center justify-between p-4 rounded-2xl border border-gray-700 bg-gray-800/30 cursor-pointer transition-all hover:bg-gray-800 group has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-500/5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-gray-700 group-has-[:checked]:bg-indigo-500/20">
                                    <svg class="w-5 h-5 text-gray-400 group-has-[:checked]:text-indigo-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                                <span class="text-gray-200 text-sm font-semibold">Siswa Spesifik</span>
                            </div>
                            <input type="radio" name="akses_pilihan" value="siswa" onclick="toggleFilter('siswa')"
                                checked
                                class="w-5 h-5 text-indigo-600 border-gray-600 bg-gray-700 focus:ring-offset-gray-900">
                        </label>

                        <label
                            class="relative flex items-center justify-between p-4 rounded-2xl border border-gray-700 bg-gray-800/30 cursor-pointer transition-all hover:bg-gray-800 group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-gray-700 group-has-[:checked]:bg-emerald-500/20">
                                    <svg class="w-5 h-5 text-gray-400 group-has-[:checked]:text-emerald-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                                <span class="text-gray-200 text-sm font-semibold">Satu Kelas</span>
                            </div>
                            <input type="radio" name="akses_pilihan" value="kelas" onclick="toggleFilter('kelas')"
                                class="w-5 h-5 text-emerald-600 border-gray-600 bg-gray-700 focus:ring-offset-gray-900">
                        </label>

                        <label
                            class="relative flex items-center justify-between p-4 rounded-2xl border border-gray-700 bg-gray-800/30 cursor-pointer transition-all hover:bg-gray-800 group has-[:checked]:border-amber-500 has-[:checked]:bg-amber-500/5">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-lg bg-gray-700 group-has-[:checked]:bg-amber-500/20">
                                    <svg class="w-5 h-5 text-gray-400 group-has-[:checked]:text-amber-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                                <span class="text-gray-200 text-sm font-semibold">Seluruh Siswa</span>
                            </div>
                            <input type="radio" name="akses_pilihan" value="semua" onclick="toggleFilter('semua')"
                                class="w-5 h-5 text-amber-600 border-gray-600 bg-gray-700 focus:ring-offset-gray-900">
                        </label>
                    </div>

                    <div class="border-t border-gray-800 pt-6">
                        <div id="filter_siswa" class="space-y-3 animate-fade-in">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Pilih Nama Siswa:</label>
                            <select name="user_id"
                                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-indigo-500 outline-none appearance-none cursor-pointer">
                                <option value="">Cari Siswa...</option>
                                @foreach ($siswas as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="filter_kelas" class="hidden space-y-3 animate-fade-in">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Pilih Tingkat Kelas:</label>
                            <select name="kelas_id"
                                class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-emerald-500 outline-none appearance-none cursor-pointer">
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-800/50 border-t border-gray-800 space-y-4 shrink-0">
                    <button type="submit" name="status" value="Buka"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-bold shadow-lg shadow-indigo-500/20 transition-all active:scale-95">
                        Proses Buat Tagihan
                    </button>

                    <div class="space-y-3">
                        <p class="text-[10px] text-center text-gray-500 uppercase font-bold tracking-widest">Atur Status
                            Tagihan:</p>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button"
                                class="py-2.5 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-500 hover:text-white border border-emerald-500/20 rounded-xl font-bold transition text-xs">
                                Buka Tagihan
                            </button>
                            <button type="button"
                                class="py-2.5 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 rounded-xl font-bold transition text-xs">
                                Tutup Tagihan
                            </button>
                        </div>
                    </div>
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

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out forwards;
        }
    </style>

    {{-- SCRIPT --}}
    <script>
        function openModal() {
            modalUTS.classList.remove('hidden')
            modalUTS.classList.add('flex')
        }

        function closeModal() {
            modalUTS.classList.add('hidden')
            modalUTS.classList.remove('flex')
        }
    </script>
    <script>
        function openAksesModal(id) {
            const modal = document.getElementById('modalAkses');
            const form = document.getElementById('formAkses');
            form.action = "{{ url('admin/tagihan/uts/akses') }}/" + id;
            modal.classList.remove('hidden');

            // Reset tampilan awal ke 'siswa' sesuai radio default
            toggleFilter('siswa');
        }

        function closeAksesModal() {
            const modal = document.getElementById('modalAkses');
            // Sembunyikan kembali modal
            modal.classList.add('hidden');
        }

        // Menutup modal jika area di luar box diklik
        function toggleFilter(pilihan) {
            const divSiswa = document.getElementById('filter_siswa');
            const divKelas = document.getElementById('filter_kelas');

            // Sembunyikan semua dulu
            divSiswa.classList.add('hidden');
            divKelas.classList.add('hidden');

            // Tampilkan yang dipilih
            if (pilihan === 'siswa') {
                divSiswa.classList.remove('hidden');
            } else if (pilihan === 'kelas') {
                divKelas.classList.remove('hidden');
            }
            // Jika 'semua', biarkan keduanya tetap tersembunyi
        }
    </script>
@endsection
