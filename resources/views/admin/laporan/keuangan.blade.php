@extends('admin.layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="bg-gray-900 rounded-2xl p-6 shadow-lg text-gray-100">
            <h2 class="text-2xl font-bold text-indigo-400 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2" />
                </svg>
                Laporan Keuangan UTS & UAS
            </h2>
            <p class="text-sm text-gray-400 mt-1">
                Rekap transaksi pembayaran tagihan siswa ( UTS / UAS )
            </p>
        </div>

        {{-- RINGKASAN --}}
        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-emerald-400">Rp {{ number_format($totalPendapatan) }}</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Total Tagihan</p>
                <h3 class="text-2xl font-bold text-indigo-400">Rp {{ number_format($totalLunas) }}</h3>
            </div>

            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Sisa Tagihan</p>
                <h3 class="text-2xl font-bold text-rose-400">Rp {{ number_format($totalbelumLunas) }}</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Jumlah Transaksi</p>
                <h3 class="text-2xl font-bold text-yellow-400">{{ $siswaLunas }}</h3>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-gray-900 rounded-2xl p-6 shadow-lg">
            <div class="flex flex-col md:flex-row gap-4">
                <select
                    class="bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500">
                    <option>Semua Jenis</option>
                    <option>UTS</option>
                    <option>UAS</option>
                </select>

                <select
                    class="bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-indigo-500">
                    <option>2024 / 2025</option>
                    <option>2023 / 2024</option>
                </select>

                <button class="bg-indigo-600 hover:bg-indigo-500 px-6 py-2 rounded-xl font-semibold text-white">
                    Terapkan
                </button>
            </div>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block bg-gray-900 rounded-2xl p-6 shadow-lg">
            <div class="overflow-x-auto rounded-xl border border-gray-700">
                <table class="min-w-full text-sm text-gray-300">
                    <thead class="bg-gray-800 text-indigo-400 uppercase text-xs">
                        <tr class="text-center">
                            <th class="px-6 py-3">Tanggal Bayar</th>
                            <th class="px-6 py-3">Kode Transaksi</th>
                            <th class="px-6 py-3">Nama Siswa</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Nominal</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($data as $item)
                            <tr class="hover:bg-gray-800 transition text-center">
                                <td class="px-6 py-3">
                                    {{ \Carbon\Carbon::parse($item->tgl_bayar)->format('d M Y') }}</td>
                                <td class="px-6 py-3 text-white font-semibold">{{ $item->tagihan->kd_tagihan }}</td>
                                <td class="px-6 py-3 text-white font-semibold">{{ $item->user->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-3">{{ $item->tagihan->jenis_tagihan }}</td>
                                <td class="px-6 py-3">Rp {{ number_format($item->jumlah_bayar) }}</td>
                                <td class="px-6 py-3 text-center flex gap-2 items-center justify-center">
                                    <span class="px-3 py-1 rounded-full text-xs bg-emerald-600/20 text-emerald-400">
                                        Lunas
                                    </span>

                                    <span class="px-3 py-1 rounded-full text-xs bg-red-600/20 text-red-400">
                                        <a href="{{ route('admin.laporan.keuangan') }}"> Cetak Struk
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <td class="px-6 py-3 text-center" colspan="6">
                                Tidak ada data
                            </td>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>

        {{-- MOBILE CARD --}}
        <div class="md:hidden space-y-4">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-4">
                <div class="flex justify-between mb-1">
                    <h3 class="font-bold text-indigo-400">Syahdan</h3>
                    <span class="text-xs px-2 py-1 rounded-full bg-emerald-600/20 text-emerald-400">
                        Lunas
                    </span>
                </div>
                <p class="text-sm text-gray-400">UTS • 10 Okt 2024</p>
                <p class="font-semibold text-white mt-1">Rp 150.000</p>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-4">
                <div class="flex justify-between mb-1">
                    <h3 class="font-bold text-indigo-400">Ahmad</h3>
                    <span class="text-xs px-2 py-1 rounded-full bg-rose-600/20 text-rose-400">
                        Belum
                    </span>
                </div>
                <p class="text-sm text-gray-400">UAS • 12 Nov 2024</p>
                <p class="font-semibold text-white mt-1">Rp 200.000</p>
            </div>
        </div>

    </div>
@endsection
