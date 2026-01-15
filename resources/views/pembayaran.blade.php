<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
    <link rel="icon" type="image/jpg" href="{{ asset('dharma_agung.jpg') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-4xl bg-white border border-gray-200 rounded-2xl shadow-xl p-8">


        <!-- ================= HEADER ================= -->
        <div class="flex flex-col md:flex-row justify-between items-center border-b pb-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-wide">
                    INVOICE PEMBAYARAN
                </h1>
                <p class="text-sm text-gray-500">
                    Nomor Invoice:
                    <span class="text-blue-600 font-semibold">#{{ $tagihan->kd_tagihan }}</span>
                </p>
            </div>
            <div class="mt-4 md:mt-0 text-right">
                <p class="text-sm text-gray-500">Tanggal Cetak</p>
                <p class="font-semibold text-gray-800">
                    {{ now()->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- ================= DATA SISWA ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 border-b mb-3">
                    Data Siswa
                </h2>
                <div class="space-y-1 text-sm text-gray-700">
                    <p><span class="text-gray-500">Nama</span> : {{ $tagihan->user->name ?? '-' }}</p>
                    <p><span class="text-gray-500">NIS</span> : {{ $tagihan->user->nis ?? '-' }}</p>
                    <p><span class="text-gray-500">Kelas</span> : {{ $tagihan->kelas->kelas ?? '-' }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-800 border-b mb-3">
                    Informasi Tagihan
                </h2>
                <div class="space-y-1 text-sm text-gray-700">
                    <p><span class="text-gray-500">Tahun Ajaran</span> :
                        {{ $tagihan->tagihan->tahun_ajaran ?? '-' }}</p>
                    <p><span class="text-gray-500">Jenis Tagihan</span> :
                        {{ $tagihan->jenis_tagihan ?? '-' }}</p>
                    <p><span class="text-gray-500">Jatuh Tempo</span> :
                        {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- ================= TABEL TAGIHAN ================= -->
        <div class="overflow-x-auto mb-6">
            <table class="w-full border border-gray-200 rounded-xl overflow-hidden text-sm">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Deskripsi</th>
                        <th class="px-4 py-3 text-right">Nominal</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            Pembayaran {{ $tagihan->jenis_tagihan }}
                            Tahun Ajaran {{ $tagihan->tagihan->tahun_ajaran }}
                        </td>
                        <td class="px-4 py-3 text-right font-semibold">
                            Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if ($tagihan->status == 'belum lunas')
                                <span class="px-4 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                    Belum Lunas
                                </span>
                            @else
                                <span class="px-4 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                    Lunas
                                </span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ================= TOTAL & ACTION ================= -->
        <div class="flex flex-col md:flex-row justify-between items-center border-t pt-5 gap-4">
            <div class="text-lg font-semibold text-gray-800">
                Total Pembayaran:
                <span class="text-blue-600 ml-2">
                    Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                </span>
            </div>

            {{-- 🔴 LOGIC TETAP --}}
            @if ($tagihan->status !== 'lunas')
                <button id="pay-button"
                    class="px-8 py-2 bg-blue-700 hover:bg-blue-600 text-white rounded-xl font-semibold shadow-lg transition">
                    💳 Bayar Sekarang
                </button>
            @else
                <a href="{{ route('dashboard') }}"
                    class="px-8 py-2 bg-blue-700 hover:bg-blue-600 text-white rounded-xl font-semibold shadow-lg transition">
                    Kembali
                </a>
            @endif
        </div>

        <!-- ================= FOOTER ================= -->
        <div class="mt-10 text-center text-xs text-gray-500 border-t pt-4">
            Terima kasih telah melakukan pembayaran.<br>
            Sistem Pembayaran Sekolah &copy; {{ date('Y') }}
        </div>

    </div>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').onclick = function() {
            fetch("{{ route('detail.bayar', $tagihan->kd_tagihan) }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.snapToken) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Membuat Transaksi',
                            text: data.error || 'Token pembayaran tidak ditemukan.',
                            confirmButtonColor: '#3085d6',
                        });
                        return;
                    }

                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            fetch("/payment/{{ $tagihan->kd_tagihan }}/lunas", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                }
                            }).then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Status tagihan sudah menjadi Lunas ✅',
                                    confirmButtonColor: '#3085d6',
                                }).then(() => {
                                    window.location.href = "/dashboard";
                                });
                            });
                        },
                        onPending: function(result) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu Pembayaran',
                                text: 'Silakan selesaikan pembayaranmu untuk melanjutkan.',
                                confirmButtonColor: '#3085d6',
                            });
                        },
                        onError: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Membayar',
                                text: 'Terjadi kesalahan saat memproses pembayaran ❌',
                                confirmButtonColor: '#d33',
                            });
                        },
                        onClose: function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Pembayaran Dibatalkan',
                                text: 'Kamu menutup pembayaran. Silakan coba lagi.',
                                confirmButtonColor: '#3085d6',
                            }).then(() => {
                                window.location.href = "/dashboard";
                            });
                        }
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: error.message,
                        confirmButtonColor: '#d33',
                    });
                });
        };
    </script>
</body>

</html>
