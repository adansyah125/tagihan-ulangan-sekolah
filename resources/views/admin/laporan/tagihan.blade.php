@extends('admin.layouts.app')

@section('title', 'Laporan Tagihan Siswa')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="bg-gray-900 rounded-2xl p-6 shadow-lg text-gray-100">
            <h2 class="text-2xl font-bold text-indigo-400 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-indigo-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a5 5 0 00-10 0v2M5 11h14v8H5z" />
                </svg>
                Laporan Tagihan Siswa
            </h2>
            <p class="text-sm text-gray-400 mt-1">
                Rekap siswa yang sudah lunas & belum lunas (UTS / UAS)
            </p>
        </div>

        {{-- SUMMARY --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Total Tagihan</p>
                <h3 class="text-2xl font-bold text-indigo-400">Rp 12.000.000</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Sudah Lunas</p>
                <h3 class="text-2xl font-bold text-emerald-400">48 Siswa</h3>
            </div>
            <div class="bg-gray-800 rounded-2xl p-5 border border-gray-700">
                <p class="text-sm text-gray-400">Belum Lunas</p>
                <h3 class="text-2xl font-bold text-rose-400">12 Siswa</h3>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-gray-900 rounded-2xl p-6 shadow-lg">
            <div class="flex flex-col md:flex-row gap-4">
                <select class="bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white">
                    <option>Semua Status</option>
                    <option>Lunas</option>
                    <option>Belum Lunas</option>
                </select>

                <select class="bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white">
                    <option>Semua Jenis</option>
                    <option>UTS</option>
                    <option>UAS</option>
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
                            <th class="px-6 py-3 text-left">Nama Siswa</th>
                            <th class="px-6 py-3 text-left">Kelas</th>
                            <th class="px-6 py-3 text-left">Jenis</th>
                            <th class="px-6 py-3 text-right">Nominal</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        {{-- BELUM LUNAS --}}
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-6 py-3 font-semibold text-white">Ahmad</td>
                            <td class="px-6 py-3">J 2023</td>
                            <td class="px-6 py-3">UAS</td>
                            <td class="px-6 py-3 text-right">Rp 200.000</td>
                            <td class="px-6 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs bg-rose-600/20 text-rose-400">
                                    Belum Lunas
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <a href="#"
                                    class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-500 px-3 py-1 rounded-lg text-white text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21l-6-6 6-6" />
                                    </svg>
                                    Kirim Pesan
                                </a>
                            </td>
                        </tr>

                        {{-- LUNAS --}}
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-6 py-3 font-semibold text-white">Syahdan</td>
                            <td class="px-6 py-3">J 2023</td>
                            <td class="px-6 py-3">UTS</td>
                            <td class="px-6 py-3 text-right">Rp 150.000</td>
                            <td class="px-6 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs bg-emerald-600/20 text-emerald-400">
                                    Lunas
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                <span class="text-xs text-gray-500 italic">-</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MOBILE --}}
        <div class="md:hidden space-y-4">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-4">
                <div class="flex justify-between">
                    <h3 class="font-bold text-indigo-400">Ahmad</h3>
                    <span class="text-xs px-2 py-1 rounded-full bg-rose-600/20 text-rose-400">
                        Belum
                    </span>
                </div>
                <p class="text-sm text-gray-400">UAS • J 2023</p>
                <p class="font-semibold text-white mt-1">Rp 200.000</p>

                <a href="#"
                    class="mt-3 inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-500 px-3 py-1 rounded-lg text-white text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21l-6-6 6-6" />
                    </svg>
                    Kirim Pesan
                </a>
            </div>
        </div>

    </div>
@endsection
