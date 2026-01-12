@extends('admin.layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="space-y-8">

        {{-- HEADER --}}
        <div class="bg-gray-900 rounded-3xl p-8 border border-gray-800 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-600/10 rounded-full blur-3xl"></div>

            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-white flex items-center gap-3 tracking-tight">
                        <div class="p-2 bg-indigo-600 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2" />
                            </svg>
                        </div>
                        Laporan Keuangan
                    </h2>
                    <p class="text-sm text-gray-500 mt-2 font-medium italic">
                        Rekapitulasi pembayaran UTS & UAS periode berjalan
                    </p>
                </div>

                <button
                    class="flex items-center justify-center gap-2 bg-gray-800 hover:bg-gray-700 text-gray-300 px-6 py-3 rounded-2xl font-bold text-sm transition-all border border-gray-700 shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Export PDF
                </button>
            </div>
        </div>

        {{-- RINGKASAN (CARDS) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $stats = [
                    [
                        'label' => 'Total Pendapatan',
                        'value' => $totalPendapatan,
                        'color' => 'emerald',
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2',
                    ],
                    [
                        'label' => 'Tagihan Lunas',
                        'value' => $totalLunas,
                        'color' => 'indigo',
                        'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    ],
                    [
                        'label' => 'Sisa Piutang',
                        'value' => $totalbelumLunas,
                        'color' => 'rose',
                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    ],
                    [
                        'label' => 'Siswa Lunas',
                        'value' => $siswaLunas,
                        'color' => 'yellow',
                        'icon' =>
                            'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div
                    class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-xl group hover:border-{{ $stat['color'] }}-500/50 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-{{ $stat['color'] }}-500/10 rounded-lg text-{{ $stat['color'] }}-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest leading-none">Live
                            Data</span>
                    </div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-tight">{{ $stat['label'] }}</p>
                    <h3 class="text-xl font-black text-white mt-1">
                        {{ is_numeric($stat['value']) ? 'Rp ' . number_format($stat['value'], 0, ',', '.') : $stat['value'] . ' Siswa' }}
                    </h3>
                </div>
            @endforeach
        </div>

        {{-- FILTER & TOOLS --}}
        <div class="bg-gray-900 rounded-3xl p-4 border border-gray-800 shadow-lg">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select name="jenis"
                        class="bg-gray-800 border-none rounded-2xl px-5 py-3 text-sm text-gray-300 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Semua Jenis Tagihan</option>
                        <option>UTS</option>
                        <option>UAS</option>
                    </select>

                    <select name="tahun"
                        class="bg-gray-800 border-none rounded-2xl px-5 py-3 text-sm text-gray-300 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option>2024 / 2025</option>
                        <option>2023 / 2024</option>
                    </select>
                </div>

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 px-8 py-3 rounded-2xl font-bold text-white shadow-lg shadow-indigo-600/20 transition-all active:scale-95">
                    Terapkan Filter
                </button>
            </form>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block bg-gray-900 rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
            <table class="min-w-full text-left">
                <thead class="bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-500 uppercase tracking-widest">Waktu Bayar
                        </th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-500 uppercase tracking-widest">Detail
                            Transaksi</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-500 uppercase tracking-widest">Siswa</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-500 uppercase tracking-widest text-right">
                            Nominal</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-500 uppercase tracking-widest text-center">
                            Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-800/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-200">
                                    {{ \Carbon\Carbon::parse($item->tgl_bayar)->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($item->tgl_bayar)->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-bold text-indigo-400 leading-none mb-1">{{ $item->tagihan->kd_tagihan }}</span>
                                    <span
                                        class="text-[11px] text-gray-500 font-medium uppercase tracking-tighter">{{ $item->tagihan->jenis_tagihan }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-300 text-sm">
                                {{ $item->user->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-black text-emerald-400">Rp
                                    {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="#"
                                        class="p-2 rounded-xl bg-gray-800 text-gray-400 hover:bg-rose-500/10 hover:text-rose-400 transition-all border border-gray-700"
                                        title="Cetak Struk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                                                stroke-width="2" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-600 italic font-medium">Belum ada
                                riwayat transaksi untuk filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARDS --}}
        <div class="md:hidden space-y-4">
            @forelse($data as $item)
                <div
                    class="bg-gray-900 border border-gray-800 rounded-3xl p-5 shadow-lg active:scale-95 transition-transform">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span
                                class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">{{ $item->tagihan->jenis_tagihan }}</span>
                            <h4 class="text-sm font-bold text-white">{{ $item->user->name ?? 'N/A' }}</h4>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-emerald-400">
                                Rp{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</div>
                            <div class="text-[10px] font-bold text-gray-600 italic">
                                {{ \Carbon\Carbon::parse($item->tgl_bayar)->format('d/m/y') }}</div>
                        </div>
                    </div>
                    <a href="#"
                        class="w-full flex items-center justify-center py-3 bg-gray-800 hover:bg-gray-700 rounded-2xl text-[11px] font-black text-gray-300 uppercase tracking-widest transition-all">
                        Lihat Struk Pembayaran
                    </a>
                </div>
            @empty
                <div
                    class="text-center py-10 bg-gray-900/50 rounded-3xl border border-dashed border-gray-800 text-gray-600 text-sm">
                    Kosong</div>
            @endforelse
        </div>

    </div>
@endsection
