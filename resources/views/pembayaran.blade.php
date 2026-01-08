<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran SPP</title>
    <link rel="icon" type="image/png" href="{{ asset('marhas.jpg') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-3xl bg-white border border-gray-200 rounded-2xl shadow-xl p-8">

        <!-- ================= HEADER ================= -->
        <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-200 pb-4 mb-6">
            <div class="text-center md:text-left">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-wide">
                    INVOICE PEMBAYARAN
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Nomor Invoice:
                    <span class="text-blue-600 font-semibold">#SPP645612635612</span>
                </p>
            </div>
            <div class="mt-4 md:mt-0 text-center md:text-right">
                <p class="text-sm text-gray-500">Tanggal Cetak</p>
                <p class="font-semibold text-gray-800">10 Mei 2024</p>
            </div>
        </div>

        <!-- ================= DATA SISWA ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-200 mb-2 text-center">
                    Data Siswa
                </h2>
                <p><span class="text-gray-500">Nama :</span> {{ $spp->user->nama ?? 'Tidak diketahui' }}</p>
                <p><span class="text-gray-500">NIS :</span> {{ $spp->user->nis ?? '-' }}</p>
                <p><span class="text-gray-500">Kelas :</span> {{ $spp->user->kelas ?? '-' }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-200 mb-2 text-center">
                    Informasi Tagihan
                </h2>
                <p><span class="text-gray-500">Jenis Tagihan :</span> {{ $spp->bulan ?? 'Tidak diketahui' }}</p>
                <p><span class="text-gray-500">Tahun :</span> {{ $spp->tahun ?? 'Tidak diketahui' }}</p>
                <p><span class="text-gray-500">Jatuh Tempo :</span> 10 Mei 2024</p>
            </div>
        </div>

        <!-- ================= TABEL TAGIHAN ================= -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full border border-gray-200 rounded-xl overflow-hidden text-sm md:text-base">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Deskripsi</th>
                        <th class="px-4 py-3 text-right">Nominal</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            Pembayaran Tagihan UTS {{ $spp->bulan ?? '-' }} {{ $spp->tahun ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">
                            Rp 10.000
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span
                                class="inline-block px-4 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full">
                                Lunas
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ================= FOOTER ================= -->
        <div class="mt-10 text-center text-gray-500 text-xs border-t border-gray-200 pt-4">
            Terima kasih telah melakukan pembayaran SPP.<br>
            Sistem Pembayaran Sekolah &copy; {{ date('Y') }}
        </div>

    </div>

</body>

</html>
