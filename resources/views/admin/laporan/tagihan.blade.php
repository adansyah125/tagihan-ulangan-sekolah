@extends('admin.layouts.app')

@section('title', 'Laporan Tagihan Siswa')

@section('content')
    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="bg-gray-900 rounded-3xl p-6 md:p-8 shadow-2xl border border-gray-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-rose-500/10 rounded-2xl border border-rose-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-rose-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tight">Laporan Tagihan</h2>
                        <p class="text-sm text-gray-500 font-medium">Monitoring siswa dengan tunggakan pembayaran</p>
                    </div>
                </div>

                {{-- Filter Cepat --}}
                <div class="flex flex-wrap gap-3">
                    <select
                        class="bg-gray-800 border-none rounded-xl px-4 py-2.5 text-xs font-bold text-gray-300 focus:ring-2 focus:ring-indigo-500">
                        <option>Semua Status</option>
                        <option>Lunas</option>
                        <option class="text-rose-400">Belum Lunas</option>
                    </select>
                    <select
                        class="bg-gray-800 border-none rounded-xl px-4 py-2.5 text-xs font-bold text-gray-300 focus:ring-2 focus:ring-indigo-500">
                        <option>Semua Jenis</option>
                        <option>UTS</option>
                        <option>UAS</option>
                    </select>
                    <button
                        class="bg-indigo-600 hover:bg-indigo-500 px-6 py-2.5 rounded-xl font-bold text-white text-xs transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                        Terapkan
                    </button>
                </div>
            </div>
        </div>

        {{-- SUMMARY STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg class="w-12 h-12 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd"
                            d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total Piutang</p>
                <h3 class="text-2xl font-black text-indigo-400 mt-1">Rp{{ number_format($totalbelumLunas, 0, ',', '.') }}
                </h3>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform text-emerald-500">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Sudah Lunas</p>
                <h3 class="text-2xl font-black text-emerald-400 mt-1">{{ $Lunas }} <span
                        class="text-xs font-medium text-gray-600 uppercase">Siswa</span></h3>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform text-rose-500">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Belum Lunas</p>
                <h3 class="text-2xl font-black text-rose-400 mt-1">{{ $BelumLunas }} <span
                        class="text-xs font-medium text-gray-600 uppercase">Siswa</span></h3>
            </div>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block bg-gray-900 rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest">Siswa</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">
                            Kelas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">
                            Jenis Tagihan</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-right">
                            Nominal</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">
                            Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-500 uppercase tracking-widest text-center">
                            Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-800/40 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-xs font-bold text-indigo-400 border border-gray-700">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-200">{{ $item->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="text-xs font-semibold text-gray-400 bg-gray-800 px-2.5 py-1 rounded-lg border border-gray-700">
                                    {{ $item->user->kelas->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">
                                {{ $item->jenis_tagihan }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span
                                    class="text-sm font-black text-white">Rp{{ number_format($item->nominal, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status == 'belum lunas')
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black bg-rose-500/10 text-rose-500 border border-rose-500/20 uppercase tracking-tighter animate-pulse">
                                        Menunggu
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 uppercase tracking-tighter">
                                        Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="https://wa.me/{{ $item->user->phone ?? '' }}?text=Halo%20{{ $item->user->name }},%20mengingatkan%20tagihan%20{{ $item->jenis_tagihan }}%20anda..."
                                    target="_blank"
                                    class="inline-flex items-center gap-2 bg-emerald-600/10 hover:bg-emerald-600 text-emerald-500 hover:text-white px-4 py-2 rounded-xl text-[11px] font-black transition-all group/btn uppercase tracking-widest border border-emerald-500/20 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 group-hover/btn:rotate-12 transition-transform" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                                    </svg>
                                    WhatsApp
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">Semua tagihan sudah
                                terselesaikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE VIEW --}}
        <div class="md:hidden space-y-4">
            @forelse ($data as $item)
                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-5 shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-2xl bg-gray-800 flex items-center justify-center font-bold text-indigo-400 border border-gray-700">
                                {{ substr($item->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-sm leading-tight">{{ $item->user->name }}</h3>
                                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                                    {{ $item->user->kelas->kelas }}</p>
                            </div>
                        </div>
                        <span
                            class="px-2 py-1 rounded-lg bg-rose-500/10 text-rose-500 text-[10px] font-black uppercase border border-rose-500/20">
                            Menunggu
                        </span>
                    </div>

                    <div class="flex justify-between items-center bg-gray-800/50 p-3 rounded-2xl mb-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase">{{ $item->jenis_tagihan }}</p>
                            <p class="text-xs font-black text-white">Rp{{ number_format($item->nominal, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-500 uppercase italic">Tunggakan</p>
                        </div>
                    </div>

                    <a href="#"
                        class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white py-3 rounded-2xl text-xs font-black transition-all active:scale-95 shadow-lg shadow-emerald-600/10">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z" />
                        </svg>
                        HUBUNGI VIA WHATSAPP
                    </a>
                </div>
            @empty
                <p class="text-center py-10 text-gray-600 italic">Data kosong</p>
            @endforelse
        </div>

    </div>
@endsection
