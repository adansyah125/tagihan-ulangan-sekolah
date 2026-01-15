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

    <div class="w-full max-w-4xl mx-auto bg-white border border-gray-200 rounded-3xl shadow-xl p-6 sm:p-8">

        <!-- ================= HEADER ================= -->
        <div class="flex flex-col sm:flex-row justify-between gap-6 border-b pb-5 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-wide flex items-center gap-2">
                    <!-- Heroicon: Document Text -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25V6.75A2.25 2.25 0 0 0 17.25 4.5H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5A2.25 2.25 0 0 0 6.75 19.5h6.75" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9h6M9 12h6M9 15h3" />
                    </svg>
                    Invoice Pembayaran
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    No. Invoice:
                    <span class="text-blue-600 font-semibold">#{{ $tagihan->kd_tagihan }}</span>
                </p>
            </div>

            <div class="text-sm text-gray-600 sm:text-right">
                <p class="flex sm:justify-end items-center gap-1">
                    <!-- Heroicon: Calendar -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v1.5M17.25 3v1.5M3 8.25h18M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v10.5A1.5 1.5 0 0 1 19.5 20.25h-15A1.5 1.5 0 0 1 3 18.75V8.25A1.5 1.5 0 0 1 4.5 6.75Z" />
                    </svg>
                    {{ now()->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- ================= INFO ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

            <!-- Data Siswa -->
            <div>
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-widest mb-4">
                    Data Siswa
                </h2>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><span class="text-gray-400">Nama</span> : {{ $tagihan->user->name ?? '-' }}</p>
                    <p><span class="text-gray-400">NIS</span> : {{ $tagihan->user->nis ?? '-' }}</p>
                    <p><span class="text-gray-400">Kelas</span> : {{ $tagihan->kelas->kelas ?? '-' }}</p>
                </div>
            </div>

            <!-- Informasi Tagihan -->
            <div>
                <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-widest mb-4">
                    Informasi Tagihan
                </h2>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><span class="text-gray-400">Tahun Ajaran</span> :
                        {{ $tagihan->tagihan->tahun_ajaran ?? '-' }}</p>
                    <p><span class="text-gray-400">Jenis</span> :
                        {{ $tagihan->jenis_tagihan ?? '-' }}</p>
                    <p><span class="text-gray-400">Jatuh Tempo</span> :
                        {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- ================= TABEL ================= -->
        <div class="overflow-x-auto mb-8">
            <table class="w-full border border-gray-200 rounded-2xl overflow-hidden text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-widest">
                    <tr>
                        <th class="px-5 py-4 text-left">Deskripsi</th>
                        <th class="px-5 py-4 text-right">Nominal</th>
                        <th class="px-5 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="px-5 py-4">
                            Pembayaran {{ $tagihan->jenis_tagihan }}<br>
                            <span class="text-gray-400 text-xs">
                                Tahun Ajaran {{ $tagihan->tagihan->tahun_ajaran }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right font-semibold">
                            Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if ($tagihan->status == 'belum lunas')
                                <span
                                    class="inline-flex items-center gap-1 px-4 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                    <!-- Heroicon: X Circle -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9.75v4.5m0 3h.008M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Belum Lunas
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1 px-4 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                    <!-- Heroicon: Check Circle -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m9 12.75 2.25 2.25L15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Lunas
                                </span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ================= TOTAL & ACTION ================= -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 border-t pt-6">
            <div class="text-lg font-semibold text-gray-800">
                Total:
                <span class="text-blue-600 ml-1">
                    Rp {{ number_format($tagihan->nominal, 0, ',', '.') }}
                </span>
            </div>

            @if ($tagihan->status !== 'lunas')
                <button id="pay-button"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-blue-700 hover:bg-blue-600 text-white rounded-xl font-semibold shadow-lg transition">
                    <!-- Heroicon: Credit Card -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>

                    Bayar Sekarang
                </button>
            @else
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-xl font-semibold shadow-lg transition">
                    Kembali
                </a>
            @endif
        </div>

        <!-- ================= FOOTER ================= -->
        <div class="mt-10 text-center text-xs text-gray-400">
            Terima kasih telah melakukan pembayaran.<br>
            Sistem Pembayaran Sekolah © {{ date('Y') }}
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
                                    text: 'Terima kasih telah melunasi tagihan ini {{ $tagihan->kd_tagihan }}',
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
                                text: 'Terjadi kesalahan saat memproses pembayaran {{ $tagihan->kd_tagihan }}',
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
