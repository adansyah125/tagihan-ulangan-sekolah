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
                Rekap pembayaran tagihan siswa berdasarkan jenis ujian
            </p>
        </div>

        {{-- RINGKASAN --}}
        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Total Tagihan</p>
                <h3 class="text-2xl font-bold text-indigo-400">Rp 12.000.000</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Total Dibayar</p>
                <h3 class="text-2xl font-bold text-emerald-400">Rp 9.500.000</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Sisa Tagihan</p>
                <h3 class="text-2xl font-bold text-rose-400">Rp 2.500.000</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Jumlah Transaksi</p>
                <h3 class="text-2xl font-bold text-yellow-400">76</h3>
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
                        <tr>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Nama Siswa</th>
                            <th class="px-6 py-3 text-left">Jenis</th>
                            <th class="px-6 py-3 text-right">Nominal</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-6 py-3">10-10-2024</td>
                            <td class="px-6 py-3 text-white font-semibold">Syahdan</td>
                            <td class="px-6 py-3">UTS</td>
                            <td class="px-6 py-3 text-right">Rp 150.000</td>
                            <td class="px-6 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs bg-emerald-600/20 text-emerald-400">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-6 py-3">12-11-2024</td>
                            <td class="px-6 py-3 text-white font-semibold">Ahmad</td>
                            <td class="px-6 py-3">UAS</td>
                            <td class="px-6 py-3 text-right">Rp 200.000</td>
                            <td class="px-6 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs bg-rose-600/20 text-rose-400">
                                    Belum
                                </span>
                            </td>
                        </tr>
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
