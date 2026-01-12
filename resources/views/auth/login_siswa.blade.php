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

<body class="min-h-screen bg-zinc-400">
    <div class="flex h-screen">

        <!-- Login Form -->
        <div class="w-full md:w-1/2 bg-white flex flex-col justify-center items-center p-8">

            <div class="text-center mb-10">
                <div class="flex justify-center mb-2">
                    {{-- <div class="bg-green-400 w-4 h-4 rounded-sm"></div>
                    <div class="bg-zinc-400 mt-2 w-4 h-4 rounded-sm -ml-2"></div> --}}
                    <img src="{{ asset('dharma_agung.jpg') }}" class=" h-25" alt="">
                </div>
                <h1 class="text-1xl font-bold text-red-700">
                    SISTEM TAGIHAN SEKOLAH
                </h1>
            </div>

            <div class="w-full max-w-sm">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">
                    Login Siswa
                </h2>

                {{-- NOTIFIKASI --}}
                @if (session('error'))
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('PostLoginSiswa') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-700">Email</label>
                        <input type="email" name="email" required
                            class="mt-1 w-full px-4 py-2 rounded-md border border-gray-300
                                   focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div class="relative">
                        <label class="block text-sm text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 w-full px-4 py-2 pr-10 rounded-md border border-gray-300
                                   focus:ring-2 focus:ring-blue-500 focus:outline-none" />

                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-9 text-gray-600">
                            <i id="toggleIcon" data-feather="eye" class="w-5 h-5"></i>
                        </button>

                        <div class="text-right mt-1">
                            <a href="#" class="text-sm text-blue-700 hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-900 text-white py-2 rounded-md
                               hover:bg-blue-800 transition">
                        Login
                    </button>
                </form>
            </div>
        </div>

        <!-- Image -->
        <div class="hidden md:block w-1/2 h-full">
            <img src="{{ asset('abu.jpg') }}"
                class="object-cover h-[600px] m-auto w-[500px] mt-10
                       rounded-3xl shadow-2xl opacity-80">
        </div>
    </div>

    <script>
        feather.replace();

        function togglePassword() {
            const password = document.getElementById('password');
            password.type = password.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>


</html>
