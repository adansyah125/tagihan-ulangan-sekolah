<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Tagihan Ulangan | Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('marhas.jpg') }}" />

    @vite('resources/css/app.css')

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 via-gray-50 to-white min-h-screen text-gray-800 font-sans">


    <!-- ================= NAVBAR ================= -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur border-b border-gray-200 shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-gray-800">
                Sistem Tagihan Sekolah
            </h1>

            <button id="menu-toggle" class="sm:hidden text-2xl text-gray-700">☰</button>

            <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                @csrf
                <button
                    class="bg-gray-800 text-white px-4 py-2 rounded-full hover:bg-gray-700 transition cursor-pointer">
                    Logout
                </button>
            </form>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden sm:hidden px-4 pb-4">
            <form method="POST">
                @csrf
                <button class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- ================= MAIN ================= -->
    <main class="pt-28 px-4 sm:px-8">

        <!-- ================= HERO ================= -->
        <section class="text-center mb-20">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                Sistem Tagihan Ulangan
            </h2>
            <p class="text-gray-600 max-w-xl mx-auto">
                Kelola dan pantau tagihan ulangan siswa dengan mudah, transparan, dan aman.
            </p>
        </section>

        <!-- ================= PROFIL SISWA ================= -->
        <section data-aos="fade-up"
            class="max-w-5xl mx-auto bg-white border border-gray-200 rounded-2xl shadow-xl p-6 sm:p-8 mb-20">

            <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">
                Profil Siswa
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
                <div class="bg-gray-100 p-4 rounded-lg">👤 <strong>Nama:</strong> Siswa</div>
                <div class="bg-gray-100 p-4 rounded-lg">🆔 <strong>NIS:</strong> 123456</div>
                <div class="bg-gray-100 p-4 rounded-lg">🏫 <strong>Kelas:</strong> 5A</div>
                <div class="bg-gray-100 p-4 rounded-lg">📍 <strong>Alamat:</strong> Bandung</div>
                <div class="bg-gray-100 p-4 rounded-lg">📧 <strong>Email:</strong> siswa@email.com</div>
                <div class="bg-gray-100 p-4 rounded-lg">📞 <strong>No. Telp:</strong> 08123456789</div>
            </div>
        </section>

        <!-- ================= RIWAYAT TAGIHAN ================= -->
        <section data-aos="fade-up"
            class="max-w-5xl mx-auto bg-white border border-gray-200 rounded-2xl shadow-xl p-6 sm:p-8 mb-24">

            <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Riwayat Tagihan Ulangan
            </h3>

            <!-- Filter -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <input type="text" placeholder="Cari Bulan"
                    class="flex-1 bg-gray-100 border border-gray-300 rounded-lg p-2">
                <input type="text" placeholder="Cari Tahun"
                    class="flex-1 bg-gray-100 border border-gray-300 rounded-lg p-2">
                <select class="flex-1 bg-gray-100 border border-gray-300 rounded-lg p-2">
                    <option>Semua Status</option>
                    <option>Lunas</option>
                    <option>Belum Lunas</option>
                </select>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700 border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Tahun AJaran</th>
                            <th class="p-3 border">Tagihan Ulangan</th>
                            <th class="p-3 border">Nominal</th>
                            <th class="p-3 border">Tanggal</th>
                            <th class="p-3 border">Jatuh Tempo</th>
                            <th class="p-3 border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">1</td>
                            <td class="p-3 border">2024/2025</td>
                            <td class="p-3 border">UTS</td>
                            <td class="p-3 border">Rp 10.000</td>
                            <td class="p-3 border">10 Mei 2024</td>
                            <td class="p-3 border">20 Mei 2024</td>
                            <td class="p-3 border">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-white border-t border-gray-200 text-center py-6 text-sm text-gray-500">
        © 2025 <span class="font-semibold text-blue-600">SPP MARHAS</span> | Design By Syahdan Mutahariq
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

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

</body>

</html>
