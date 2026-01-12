@extends('admin.layouts.app')

@section('title', 'Tagihan UTS')

@section('content')
    <div class="bg-gray-900 text-gray-100 rounded-3xl p-4 md:p-8 shadow-2xl border border-gray-800">

        {{-- HEADER & SEARCH --}}
        <div class="flex flex-col gap-6 mb-8">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-indigo-600/20 rounded-2xl border border-indigo-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">Monitor Pembayaran</h2>
                    <p class="text-xs text-gray-500 font-medium italic">Pantau status transaksi siswa secara real-time</p>
                </div>
            </div>

            {{-- Form Pencarian --}}
            <form method="GET" class="relative group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 group-focus-within:text-indigo-400 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama siswa, kelas, atau kode tagihan..."
                    class="w-full md:w-1/2 lg:w-1/3 pl-12 pr-4 py-3.5 rounded-2xl bg-gray-800/50 border border-gray-700 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-800 transition-all shadow-inner" />
            </form>
        </div>

        {{-- GRID DATA --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($data as $item)
                <div
                    class="group bg-gray-800/40 border border-gray-700/50 rounded-3xl p-5 hover:border-indigo-500/50 hover:bg-gray-800 transition-all duration-300 shadow-lg relative overflow-hidden">

                    {{-- Decorator Status (Garis Samping) --}}
                    <div
                        class="absolute top-0 left-0 w-1.5 h-full {{ $item->status === 'lunas' ? 'bg-emerald-500' : 'bg-rose-500' }}">
                    </div>

                    {{-- Card Header --}}
                    <div class="flex justify-between items-start mb-4">
                        <div class="max-w-[70%]">
                            <span
                                class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ $item->jenis_tagihan }}</span>
                            <h3
                                class="font-bold text-white truncate text-sm leading-tight group-hover:text-indigo-400 transition-colors">
                                {{ $item->tahun_ajaran }}
                            </h3>
                            <p class="text-[10px] font-mono text-gray-600 mt-1">#{{ $item->kd_tagihan }}</p>
                        </div>

                        @if ($item->status === 'lunas')
                            <div class="flex flex-col items-end">
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[10px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 tracking-tighter">
                                    Sudah Dibayar
                                </span>
                            </div>
                        @else
                            <div class="flex flex-col items-end">
                                <span
                                    class="px-2.5 py-1 rounded-lg text-[10px] font-black bg-rose-500/10 text-rose-400 border border-rose-500/20 uppercase tracking-tighter animate-pulse">
                                    Belum Dibayar
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Card Body --}}
                    <div class="space-y-3 p-3 bg-gray-900/50 rounded-2xl border border-gray-700/30 mb-5">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-500/10 flex items-center justify-center text-xs font-bold text-indigo-400 border border-indigo-500/20">
                                {{ substr($item->user->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-xs text-gray-500 font-medium leading-none mb-1">Nama Siswa</p>
                                <p class="text-sm text-gray-200 font-semibold truncate">{{ $item->user->name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 border-t border-gray-700/50 pt-3">
                            <div>
                                <p class="text-[10px] text-gray-500 font-medium uppercase">Kelas</p>
                                <p class="text-xs text-white font-bold">{{ $item->kelas->kelas }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-500 font-medium uppercase">Nominal</p>
                                <p class="text-xs text-indigo-400 font-black">
                                    Rp{{ number_format($item->nominal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex-1">
                            <p class="text-[10px] text-gray-500 font-medium uppercase">Batas Waktu</p>
                            <p class="text-[11px] text-gray-300 font-bold italic">
                                {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/y') }}
                            </p>
                        </div>

                        <button
                            class="flex items-center justify-center p-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white transition-all active:scale-95 shadow-lg shadow-indigo-600/20 group/btn">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>

                </div>
            @empty
                <div
                    class="col-span-full flex flex-col items-center justify-center py-20 bg-gray-800/20 rounded-3xl border-2 border-dashed border-gray-800">
                    <div class="p-4 bg-gray-800 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 font-medium">Siswa atau kode tagihan tidak ditemukan</p>
                    <a href="{{ url()->current() }}"
                        class="mt-2 text-indigo-400 text-sm hover:underline font-bold italic">Reset Pencarian</a>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-10 px-2 flex justify-center">
            <div class="w-full md:w-auto">
                {{ $data->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
@endsection
