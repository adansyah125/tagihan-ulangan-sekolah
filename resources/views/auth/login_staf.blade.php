<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KampusTime</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("data-feather", "eye-off");
            } else {
                input.type = "password";
                icon.setAttribute("data-feather", "eye");
            }

            feather.replace();
        }
    </script>

</head>

<body
    class="min-h-screen bg-gradient-to-br from-pink-100 via-orange-100 to-red-100 flex items-center justify-center px-4">

    <!-- CARD -->
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT PANEL -->
        <div
            class="relative hidden md:flex flex-col items-center justify-center text-center 
           bg-gradient-to-br from-pink-500 via-orange-500 to-red-500 px-10">

            <h2 class="text-white text-3xl font-semibold leading-tight max-w-md">
                Selamat Datang di
                <span class="block font-bold">
                    Sistem Tagihan Ulangan
                </span>
                <span class="block text-2xl font-medium mt-1">
                    Sekolah Dharma Agung Bandung
                </span>
            </h2>

            <!-- Decorative -->
            <div class="absolute top-10 left-10 w-32 h-32 bg-white/20 rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-40 h-40 bg-white/10 rounded-full"></div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="p-8 md:p-12 flex flex-col justify-center">

            <!-- LOGO -->
            <div class="text-center mb-8">
                <img src="{{ asset('dharma_agung.jpg') }}" class="h-20 mx-auto mb-3" alt="">
                <h1 class="text-sm font-bold text-red-700 tracking-wide">
                    SISTEM TAGIHAN SEKOLAH
                </h1>
            </div>

            <h2 class="text-md font-semibold  text-gray-900 text-center">
                Portal Staf Administrasi
            </h2>
            <h2 class="text-sm italic  text-gray-500 mb-6 text-center">
                Silahkan masuk terlebih dahulu
            </h2>

            {{-- NOTIFIKASI --}}
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- FORM (FUNGSI TETAP) -->
            <form action="{{ route('PostLoginStaf') }}" method="POST" class="space-y-5">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full border-b border-gray-300 focus:border-pink-500 outline-none py-2 text-sm">
                </div>

                <!-- PASSWORD -->
                <div class="relative">
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full border-b border-gray-300 focus:border-pink-500 outline-none py-2 pr-10 text-sm">

                    <button type="button" onclick="togglePassword()" class="absolute right-2 top-8 text-gray-500">
                        <i id="toggleIcon" data-feather="eye" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-orange-500 text-white py-2 rounded-md font-medium hover:opacity-90 transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>


</html>
