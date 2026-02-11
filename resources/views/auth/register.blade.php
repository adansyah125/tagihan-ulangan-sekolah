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
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden justify-center ">
        <!-- RIGHT PANEL -->
        <div class="p-8 md:p-12 flex flex-col justify-center">

            <!-- LOGO -->
            <div class="text-center mb-8">
                <img src="{{ asset('dharma_agung.jpg') }}" class="h-20 mx-auto mb-3" alt="">
                <h1 class="text-sm font-bold text-red-700 tracking-wide">
                    SISTEM TAGIHAN SEKOLAH DHARMA AGUNG
                </h1>
            </div>

            <h2 class="text-md font-semibold  text-gray-900 text-center">
                Portal Pendaftaran Siswa
            </h2>
            <h2 class="text-sm italic  text-gray-500 mb-6 text-center">
                Silahkan Daftar terlebih dahulu
            </h2>

            {{-- NOTIFIKASI --}}
            @if (session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- FORM (FUNGSI TETAP) -->
            <form action="{{ route('PostRegisterSiswa') }}" method="POST"
                class="space-y-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                @csrf

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">Nama
                                Lengkap</label>
                            <input type="text" id="nama" name="name" required placeholder="Masukkan nama"
                                class="w-full border-b-2 border-gray-200 focus:border-pink-500 outline-none py-2 px-1 text-sm transition-colors duration-300">
                        </div>

                        <div>
                            <label for="nis"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">NIS</label>
                            <input type="text" id="nis" name="nis" required placeholder="Nomor Induk Siswa"
                                class="w-full border-b-2 border-gray-200 focus:border-pink-500 outline-none py-2 px-1 text-sm transition-colors duration-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email"
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                placeholder="contoh@email.com"
                                class="w-full border-b-2 border-gray-200 focus:border-pink-500 outline-none py-2 px-1 text-sm transition-colors duration-300 {{ $errors->has('email') ? 'border-red-500 focus:border-red-500' : 'border-gray-200 focus:border-pink-500' }}">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">Kelas</label>
                            <div class="relative">
                                <select name="kelas_id" required
                                    class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-pink-500 focus:border-transparent outline-none appearance-none cursor-pointer transition-all text-gray-700">
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    @foreach ($kelas as $data)
                                        <option value="{{ $data->id }}">{{ $data->kelas }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="telp"
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">No.
                            WhatsApp</label>
                        <input type="tel" id="telp" name="telp" required placeholder="0812..."
                            class="w-full border-b-2 border-gray-200 focus:border-pink-500 outline-none py-2 px-1 text-sm transition-colors duration-300">
                    </div>

                    <div>
                        <label for="alamat"
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">Alamat
                            Lengkap</label>
                        <textarea id="alamat" name="alamat" required rows="2" placeholder="Tuliskan alamat rumah..."
                            class="w-full border-b-2 border-gray-200 focus:border-pink-500 outline-none py-2 px-1 text-sm transition-colors duration-300 resize-none"></textarea>
                    </div>

                    <div class="relative">
                        <label for="password"
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 ml-1">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                class="w-full border-b-2 border-gray-200 focus:border-pink-500 outline-none py-2 pr-10 px-1 text-sm transition-colors duration-300">
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-1 top-2 text-gray-400 hover:text-pink-500 transition-colors">
                                <i id="toggleIcon" data-feather="eye" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-4 space-y-4">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-pink-500 text-white py-3 rounded-xl font-bold shadow-lg shadow-orange-200 hover:shadow-orange-300 hover:scale-[1.01] active:scale-[0.98] transition-all cursor-pointer">
                        Masuk ke Akun
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        Sudah memiliki akun?
                        <a href="{{ route('log_siswa') }}"
                            class="text-pink-600 font-bold hover:text-pink-700 hover:underline transition-colors">Login
                            !</a>
                    </p>
                </div>
            </form>
        </div>
    </div>


    <script>
        feather.replace();
    </script>
</body>

</html>
