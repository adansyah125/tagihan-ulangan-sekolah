@extends('admin.layouts.app')

@section('title', 'Tagihan UTS')

@section('content')
    <div class="bg-gray-900 text-gray-100 rounded-2xl p-6 shadow-lg">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                </svg>
                Tagihan UTS
            </h2>

            <button onclick="openModal()"
                class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl text-white font-semibold transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Buat Tagihan
            </button>
        </div>

        {{-- 💻 DESKTOP TABLE --}}
        <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-700">
            <table class="min-w-full text-sm text-gray-300">
                <thead class="bg-gray-800 text-gray-300 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Tahun Ajaran</th>
                        <th class="px-6 py-3 text-left">Nominal</th>
                        <th class="px-6 py-3 text-left">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left">Jatuh Tempo</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-6 py-3">{{ $item->jenis_tagihan }} {{ $item->tahun_ajaran }}</td>
                            <td class="px-6 py-3 font-semibold text-white">Rp {{ number_format($item->nominal) }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($item->tgl_tagihan)->format('d M Y') }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                @if ($item->status == 'Buka')
                                    <span class="px-3 py-1 rounded-full text-xs bg-emerald-600/20 text-emerald-400">
                                        Aktif
                                    </span>
                                @elseif($item->status !== 'Buka')
                                    <span class="px-3 py-1 rounded-full text-xs bg-red-600/20 text-red-400">
                                        Tutup
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center flex gap-2 items-center justify-center">
                                <button
                                    class="bg-rose-500 hover:bg-rose-500 px-3 py-1 rounded-lg text-white text-xs cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <td class="px-6 py-3 text-center" colspan="5">Tidak ada data</td>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📱 MOBILE CARD --}}
        <div class="md:hidden space-y-4">
            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-4 shadow">
                <div class="flex justify-between mb-2">
                    <h3 class="font-bold text-indigo-400">2024 / 2025</h3>
                    <span class="text-xs px-2 py-1 rounded-full bg-emerald-600/20 text-emerald-400">
                        Aktif
                    </span>
                </div>
                <p class="text-sm"><span class="text-gray-400">Nominal:</span> Rp 150.000</p>
                <p class="text-sm mb-3"><span class="text-gray-400">Jatuh Tempo:</span> 10 Okt 2024</p>
                <button class="w-full bg-rose-600 hover:bg-rose-500 py-2 rounded-xl text-white text-sm">
                    Tutup Tagihan
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="modalUTS" class="fixed inset-0 hidden z-50 bg-black/60 backdrop-blur-sm items-center justify-center">

        <div class="bg-gray-900 w-full max-w-lg mx-4 rounded-2xl shadow-2xl border border-gray-700 animate-scale">

            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                <h3 class="text-lg font-bold text-indigo-400">Buka Tagihan UTS</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-400">✕</button>
            </div>

            <form class="p-6 space-y-4" action="{{ route('admin.tagihan.uts.store') }}" method="POST">
                @csrf

                <div>
                    <label class="text-sm text-gray-400">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white
                    focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-sm text-gray-400">Nominal</label>
                    <input type="number" name="nominal"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white
                    focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="text-sm text-gray-400">Tanggal Mulai</label>
                    <input type="date" name="tgl_tagihan"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white
                    focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="text-sm text-gray-400">Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo"
                        class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2 text-white
                    focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 rounded-xl bg-gray-700 hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 font-semibold">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

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
@endsection
