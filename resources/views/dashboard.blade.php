<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Tagihan Ulangan | Dashboard</title>
    <link rel="icon" type="image/jpg" href="{{ asset('dharma_agung.jpg') }}" />

    @vite('resources/css/app.css')

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen text-gray-800 font-sans">


    <!-- ================= NAVBAR ================= -->
    <nav class="fixed top-0 w-full bg-white/70 backdrop-blur-md border-b border-gray-100 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-transparent rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                    <img src="{{ asset('dharma_agung.jpg') }}" class="w-10" alt="">
                </div>
                <h1 class="text-lg font-bold text-gray-800 tracking-tight">
                    Dharma Agung <span class="text-red-600">Bandung</span>
                </h1>
            </div>

            <div class="hidden sm:flex items-center gap-6">
                <div class="text-right mr-2">
                    <p class="text-[10px] font-bold text-gray-400 ">Status Siswa
                    </p>
                    <p class="text-sm font-bold text-gray-700">{{ Auth()->user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-gray-600 text-white px-6 py-2 rounded-xl font-bold text-xs hover:bg-red-600 transition-all active:scale-95 shadow-lg shadow-gray-200 cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>

            <button id="menu-toggle" class="sm:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden sm:hidden bg-white border-t border-gray-50 px-6 py-6 shadow-xl">
            <div class="mb-6">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Akun Anda</p>
                <p class="text-gray-800 font-bold">{{ Auth()->user()->name }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="w-full bg-red-50 text-red-600 font-bold py-3 rounded-xl hover:bg-red-600 hover:text-white transition-all text-sm uppercase tracking-widest">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- ================= MAIN ================= -->
    <main class="pt-32 pb-20 px-4 sm:px-8">

        <section class="max-w-7xl mx-auto mb-16 flex flex-col items-center text-center" data-aos="fade-down">
            <div class="bg-indigo-50 text-red-600 px-4 py-1.5 rounded-full text-xs   tracking-widest mb-6">
                Sistem Informasi Pembayaran
            </div>
            <img src="{{ asset('tes.png') }}" class="h-48 mb-8 drop-shadow-2xl" alt="Hero Image">
            <h2 class="text-4xl sm:text-5xl  text-slate-900 mb-4 tracking-tight">
                Tagihan Ulangan Siswa
            </h2>
            <p class="text-slate-500 max-w-xl mx-auto font-medium leading-relaxed">
                Kelola dan pantau tagihan ulangan Anda dengan mudah, transparan, dan aman dalam satu platform.
            </p>
        </section>

        <section data-aos="fade-up"
            class="max-w-5xl mx-auto bg-white border border-slate-200 rounded-[2.5rem] shadow-sm p-8 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full -mr-16 -mt-16"></div>

            <h3 class="text-xl  text-slate-800 mb-8 flex items-center gap-2">
                <span
                    class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm">👤</span>
                Profil Siswa
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400  tracking-widest">Nama Lengkap</p>
                    <p class="text-slate-700 font-bold">{{ Auth()->user()->name }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400  tracking-widest">Nomor Induk Siswa</p>
                    <p class="text-slate-700 font-bold">{{ Auth()->user()->nis }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400  tracking-widest">Kelas</p>
                    <p class="text-slate-600 ">{{ Auth()->user()->kelas->kelas ?? '-' }}</p>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400  tracking-widest">Alamat</p>
                    <p class="text-slate-700 font-medium">{{ Auth()->user()->alamat ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400  tracking-widest">No Whatsapp</p>
                    <p class="text-slate-700 font-medium">{{ Auth()->user()->telp ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-slate-400  tracking-widest">Email</p>
                    <p class="text-slate-700 font-medium">{{ Auth()->user()->email }}</p>
                </div>
            </div>
        </section>

        <section class="max-w-5xl mx-auto mb-20">
            <h3 class="text-xl  text-slate-800 mb-6 px-2">Tagihan Aktif</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @forelse ($payment as $item)
                    <div
                        class="bg-white border-2 border-slate-100 rounded-[2rem] p-8 hover:border-indigo-500 transition-all duration-300 group shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <div class="p-3 bg-indigo-50 rounded-2xl group-hover:bg-indigo-600 transition-colors">
                                    {{-- <svg class="w-6 h-6 text-indigo-600 group-hover:text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg> --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-6 h-6 text-indigo-600 group-hover:text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                    </svg>

                                </div>
                                <span
                                    class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px]  rounded-lg border border-rose-100 animate-pulse">
                                    Belum Lunas
                                </span>
                            </div>

                            <h4 class="text-lg  text-slate-800 leading-tight mb-2">
                                {{ $item->jenis_tagihan }}
                            </h4>
                            <p class="text-xs font-medium text-slate-500 mb-6">
                                Tagihan untuk keperluan {{ $item->jenis_tagihan }} TA
                                {{ $item->tagihan?->tahun_ajaran }}.
                            </p>
                        </div>

                        <div>
                            <div class="mb-6">
                                <p class="text-[10px]  text-slate-400  tracking-widest mb-1">Total
                                    Bayar</p>
                                <p class="text-3xl  text-slate-900">
                                    Rp{{ number_format($item->nominal, 0, ',', '.') }}</p>
                            </div>

                            @if ($item->status === 'belum lunas' && $item->tagihan?->status == 'Buka')
                                <a href="{{ route('payment', $item->kd_tagihan) }}"
                                    class="block w-full text-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl  text-xs transition-all shadow-lg shadow-indigo-100 active:scale-95  tracking-widest">
                                    Bayar Sekarang
                                </a>
                            @elseif($item->status === 'lunas')
                            @else
                                <span
                                    class="block w-full text-center py-4 bg-slate-500 hover:bg-slate-700 text-white rounded-2xl  text-xs transition-all shadow-lg shadow-indigo-100 active:scale-95  tracking-widest">
                                    Terkunci
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-12 text-center bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                        <p class="text-slate-400  italic text-sm text-center">Tidak ada tagihan aktif saat ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </section>

        <section data-aos="fade-up"
            class="max-w-5xl mx-auto bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden p-6 sm:p-8">

            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8">
                <div class="text-center md:text-left">
                    <h3 class="text-xl text-slate-800">Riwayat Tagihan</h3>
                    <p class="text-xs text-slate-400 italic">Data seluruh riwayat tagihan Anda</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                    <input id="searchInput" type="text" placeholder="Cari..."
                        class="w-full sm:w-40 bg-slate-50 border border-gray-400 rounded-xl px-4 py-2 text-xs focus:ring-2 focus:ring-indigo-500 tracking-widest">

                    <select id="statusFilter"
                        class="w-full sm:w-40 bg-slate-50 border border-gray-400 rounded-xl px-4 py-2 text-xs focus:ring-2 focus:ring-indigo-500 tracking-widest">
                        <option value="">Semua Status</option>
                        <option value="lunas">Lunas</option>
                        <option value="belum lunas">Belum Lunas</option>
                    </select>
                </div>
            </div>


            {{-- DEFAULT --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <th class="pb-5 px-4 text-[10px]  text-slate-400  tracking-widest text-center">
                                No</th>

                            <th class="pb-5 px-4 text-[10px]  text-slate-400  tracking-widest text-center">
                                Tahun Ajaran</th>
                            <th class="pb-5 px-4 text-[10px]  text-slate-400  tracking-widest text-center">
                                Masa berlaku</th>
                            <th class="pb-5 px-4 text-[10px]  text-slate-400  tracking-widest text-center">
                                Nominal</th>
                            <th class="pb-5 px-4 text-[10px]  text-slate-400  tracking-widest text-center">
                                Status</th>
                            <th class="pb-5 px-4 text-[10px]  text-slate-400  tracking-widest text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($data as $item)
                            <tr class="hover:bg-indigo-50/30 transition-colors group"
                                data-status="{{ strtolower($item->status) }}">

                                <td class="py-6 px-4 text-sm  text-slate-400 text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-6 px-4 text-sm  text-slate-800 text-center">
                                    {{ $item->jenis_tagihan }} {{ $item->tagihan?->tahun_ajaran ?? '-' }}
                                </td>
                                <td class="py-6 px-4 text-sm  text-slate-600  text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span>{{ \Carbon\Carbon::parse($item->tgl_tagihan)->format('d M Y') }}</span>
                                        <span class="text-gray-600">→</span>
                                        <span
                                            class="text-red-600/80">{{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-6 px-4  text-indigo-600 text-sm text-center">
                                    Rp{{ number_format($item->nominal, 0, ',', '.') }}
                                </td>
                                <td class="py-6 px-4 text-center">
                                    <span
                                        class="inline-block px-4 py-1.5 {{ $item->status == 'lunas' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }} rounded-full text-[9px]   tracking-widest">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="py-6 px-4 text-center">
                                    @if ($item->status == 'belum lunas' && $item->tagihan?->status == 'Buka')
                                        <a href="{{ route('payment', $item->kd_tagihan) }}"
                                            class="inline-flex gap-1 bg-indigo-600 text-white px-6 py-2 rounded-xl text-[9px]  hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all  tracking-widest">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="h-3 w-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                            </svg>

                                            Bayar
                                        </a>
                                    @elseif($item->status == 'lunas')
                                        <a href="{{ route('cetak', $item->kd_tagihan) }}" target="_blank"
                                            class="inline-flex gap-1 bg-gray-600 text-white px-6 py-2 rounded-xl text-[9px]  hover:bg-red-600 hover:shadow-lg hover:shadow-slate-200 transition-all  tracking-widest">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="h-3 w-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                            </svg>

                                            Cetak
                                        </a>
                                    @else
                                        <span
                                            class="text-slate-300 text-[9px]   tracking-widest italic bg-slate-50 px-4 py-2 rounded-lg">
                                            Terkunci
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr id="noDataRow" class="hidden">
                                <td colspan="6" class="py-6 px-4 text-sm  text-gray-400 text-center">
                                    Tidak ada data yang sesuai
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MOBILE --}}
            <div class="block sm:hidden space-y-4">
                @forelse ($data as $item)
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100"
                        data-status="{{ strtolower($item->status) }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-[9px]  text-slate-400  tracking-widest">Jenis Tagihan
                                </p>
                                <p class="text-sm  text-slate-800 ">{{ $item->jenis_tagihan }}</p>
                            </div>
                            <span
                                class="px-2 py-1 {{ $item->status == 'lunas' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} rounded-lg text-[9px] ">
                                {{ $item->status }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-[9px]  text-slate-400  tracking-widest">Tahun Ajaran
                                </p>
                                <p class="text-xs font-bold text-slate-700">{{ $item->tagihan?->tahun_ajaran ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-[9px]  text-slate-400  tracking-widest text-right">
                                    Nominal</p>
                                <p class="text-xs  text-slate-900 text-right text-indigo-600">
                                    Rp{{ number_format($item->nominal, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200">
                            @if ($item->status == 'belum lunas' && $item->tagihan?->status == 'Buka')
                                <a href="{{ route('payment', $item->kd_tagihan) }}"
                                    class="block w-full text-center bg-indigo-600 text-white py-3 rounded-xl text-[10px]   tracking-[0.2em]">Bayar
                                    Sekarang</a>
                            @elseif($item->status == 'lunas')
                                <a href="{{ route('payment', $item->kd_tagihan) }}"
                                    class="block w-full text-center bg-slate-900 text-white py-3 rounded-xl text-[10px]   tracking-[0.2em]">Cetak
                                    Kwitansi</a>
                            @else
                                <button disabled
                                    class="w-full text-center bg-slate-200 text-slate-400 py-3 rounded-xl text-[10px]   tracking-[0.2em] cursor-not-allowed">Terkunci</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center py-10 text-xs  text-slate-400  tracking-widest">Data tidak
                        ditemukan</p>
                @endforelse
            </div>
        </section>
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-white border-t border-gray-200 text-center py-6 text-sm text-gray-500">
        © 2025 <span class="font-semibold text-blue-600">SISTEM TAGIHAN SEKOLAH</span> | Design By Syahdan Mutahariq
    </footer>

    <!-- ================= SCRIPT ================= -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

    <script>
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('tbody tr:not(#noDataRow)');
        const noDataRow = document.getElementById('noDataRow');

        function filterTable() {
            const search = searchInput.value.toLowerCase();
            const status = statusFilter.value.toLowerCase();

            let visibleCount = 0;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const rowStatus = row.dataset.status;

                const matchSearch = text.includes(search);
                const matchStatus = status === '' || rowStatus === status;

                if (matchSearch && matchStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // tampilkan "tidak ada data"
            noDataRow.classList.toggle('hidden', visibleCount !== 0);
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
    </script>




</body>

</html>
