<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Tagihan Ulangan| Dashboard</title>

    <!-- Tailwind (via Vite / CDN fallback) -->
    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Animasi sidebar */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        @media (min-width: 768px) {
            .sidebar-hidden {
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scale {
            animation: scaleIn .25s ease-out;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-gray-100 font-sans flex min-h-screen overflow-x-hidden">



    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 w-64 bg-gray-800/60 backdrop-blur-xl border-r border-gray-700 z-50 sidebar-transition sidebar-hidden flex flex-col shadow-2xl">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
            <h1 class="text-xl font-bold flex items-center gap-2 text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 14v8m6-11.422A12.083 12.083 0 0118 20.944M6 20.944A12.083 12.083 0 0112 10.578" />
                </svg>
                <span class="text-sm">Sistem Tagihan Sekolah</span>
            </h1>
            <button id="closeSidebar" class="md:hidden text-gray-400 hover:text-white transition">
                ✕
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <!-- Dashboard -->
            <a href="/admin/dashboard"
                class="flex items-center gap-3 px-4 py-2 rounded-lg bg-gray-700 text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>

                Dashboard
            </a>

            <!-- Data Siswa -->
            <a href="/admin/siswa"
                class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-700/70 text-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                Data Siswa
            </a>

            <!-- TAGIHAN DROPDOWN -->
            <div>
                <button onclick="toggleTagihan()"
                    class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-700/70 text-gray-300 transition">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 3h10a2 2 0 012 2v14l-7-3-7 3V5a2 2 0 012-2z" />
                        </svg>


                        Tagihan
                    </span>

                    <!-- Arrow -->
                    <svg id="iconTagihan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>

                </button>

                <!-- Dropdown -->
                <div id="menuTagihan" class="hidden ml-5 mt-2 space-y-1">
                    <a href="/admin/tagihan/uts"
                        class="block px-4 py-2 rounded-lg text-sm hover:bg-gray-700/60 text-gray-300 transition">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 0 1 9 14.437V9.564Z" />
                            </svg>
                            UTS
                        </span>
                    </a>
                    <a href="/admin/tagihan/uas"
                        class="block px-4 py-2 rounded-lg text-sm hover:bg-gray-700/60 text-gray-300 transition">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 9.563C9 9.252 9.252 9 9.563 9h4.874c.311 0 .563.252.563.563v4.874c0 .311-.252.563-.563.563H9.564A.562.562 0 0 1 9 14.437V9.564Z" />
                            </svg>
                            UAS
                        </span>
                    </a>
                </div>
            </div>
            <!-- Laporan -->
            <div>
                <button onclick="toggleLaporan()"
                    class="w-full flex items-center justify-between px-4 py-2 rounded-lg hover:bg-gray-700/70 text-gray-300 transition">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        Laporan
                    </span>

                    <!-- Arrow -->
                    <svg id="iconLaporan" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>

                </button>

                <!-- Dropdown -->
                <div id="menuLaporan" class="hidden ml-5 mt-2 space-y-1">
                    <a href="/admin/laporan/keuangan"
                        class="block px-4 py-2 rounded-lg text-sm hover:bg-gray-700/60 text-gray-300 transition">
                        <span class="flex item-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                            Keuangan
                        </span>
                    </a>
                    <a href="/admin/laporan/tagihan"
                        class="block px-4 py-2 rounded-lg text-sm hover:bg-gray-700/60 text-gray-300 transition">
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                            </svg>
                            Laporan Tagihan
                        </span>
                    </a>
                </div>
            </div>


        </nav>



        <div class="p-4 border-t border-gray-700">
            <form action="{{ route('logout.staf') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded-lg transition text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-14V5" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-40 md:hidden transition-opacity">
    </div>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-h-screen md:ml-64">
        <!-- Header -->
        <header
            class="flex items-center justify-between px-6 py-4 bg-gray-800/60 backdrop-blur-xl shadow-lg sticky top-0 z-30">
            <button id="hamburger" class="md:hidden p-2 rounded-lg hover:bg-gray-700/50 transition">
                ☰
            </button>

            <div class="flex items-center gap-4 ml-auto">
                <span class="text-sm opacity-80">Syahdan</span>
                <img src="https://api.dicebear.com/9.x/avataaars/svg?seed=Admin"
                    class="w-10 h-10 rounded-full border-2 border-gray-400" />
            </div>
        </header>

        <!-- Content -->
        <main class="p-6 flex-1 overflow-x-hidden">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger');
        const closeSidebar = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        hamburger.addEventListener('click', () => {
            sidebar.classList.remove('sidebar-hidden');
            overlay.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('sidebar-hidden');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('sidebar-hidden');
            overlay.classList.add('hidden');
        });
    </script>
    <script>
        function toggleTagihan() {
            const menu = document.getElementById('menuTagihan');
            const icon = document.getElementById('iconTagihan');

            menu.classList.toggle('hidden');
            icon.classList.toggle('rotate-90');
        }

        function toggleLaporan() {
            const menu = document.getElementById('menuLaporan');
            const icon = document.getElementById('iconLaporan');

            menu.classList.toggle('hidden');
            icon.classList.toggle('rotate-90');
        }
    </script>

</body>

</html>
