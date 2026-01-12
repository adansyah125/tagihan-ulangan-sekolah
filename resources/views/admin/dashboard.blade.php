@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-gray-800/60 backdrop-blur-xl border border-gray-700 p-6 rounded-2xl">
            <h3 class="text-lg font-semibold mb-2">Tagihan Ulangan UAS/UTS</h3>
            <p class="text-3xl font-bold text-gray-200">Rp 250.000</p>
        </div>
        <div class="bg-gray-800/60 backdrop-blur-xl border border-gray-700 p-6 rounded-2xl">
            <h3 class="text-lg font-semibold mb-2">Total Tagihan Siswa Bulan Ini</h3>
            <p class="text-3xl font-bold text-gray-300">{{ $tagihan }}</p>
        </div>
        <div class="bg-gray-800/60 backdrop-blur-xl border border-gray-700 p-6 rounded-2xl">
            <h3 class="text-lg font-semibold mb-2">Siswa Aktif</h3>
            <p class="text-3xl font-bold text-gray-400">{{ $siswa }}</p>
        </div>
    </div>

    <div class="mt-10 bg-gray-800/60 backdrop-blur-xl border border-gray-700 p-6 rounded-2xl">
        <h3 class="text-lg font-semibold mb-4 text-white">Total Keseluruhan Pembayaran Tagihan</h3>

        <div class="relative h-64 w-full">
            <canvas id="chartSPP"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pastikan DOM sudah siap
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chartSPP').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($bulanLabels),
                    datasets: [{
                        label: 'Total Pembayaran Tagihan Ulangan',
                        data: @json($dataNominal),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.3)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Agar mengikuti tinggi container div
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)' // Garis grid tipis agar cocok dengan mode gelap
                            },
                            ticks: {
                                color: '#9ca3af' // Warna teks angka samping
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af' // Warna teks bulan
                            }
                        }
                    }
                }
            });
        });
    </script>


    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top', // 🔹 posisi atas
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: '#333',
                color: '#fff',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top', // 🔹 posisi atas
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: '#ff4d4d',
                color: '#fff',
            });
        </script>
    @endif
@endsection
