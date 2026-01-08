@extends('admin.layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="bg-gray-800/60 backdrop-blur-xl text-gray-100 rounded-2xl p-6 shadow-2xl border border-gray-700">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l9-5-9-5-9 5 9 5zM12 14v7m0-7l-9-5m9 5l9-5" />
                </svg>
                Data Siswa
            </h2>

            <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                <input type="text" id="searchInput" placeholder="Cari nama atau NIS..."
                    class="bg-gray-900/60 text-gray-100 border border-gray-700 rounded-xl px-4 py-2 w-full md:w-64
                focus:ring-2 focus:ring-gray-500 focus:outline-none placeholder-gray-500">

                <button onclick="openModal()"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-xl text-white font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Siswa
                </button>
            </div>
        </div>

        {{-- 💻 Desktop Table --}}
        <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-700">
            <table class="min-w-full text-sm text-gray-300" id="dataTable">
                <thead class="bg-gray-900/70 text-gray-400 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">NIS</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Kelas</th>
                        <th class="px-6 py-3 text-left">Alamat</th>
                        <th class="px-6 py-3 text-left">Orang tua</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700" id="siswaTable">
                    @forelse ($data as $item)
                        <tr class="hover:bg-gray-800/60 transition siswa-row">
                            <td class="px-6 py-3">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3">{{ $item->nis }}</td>
                            <td class="px-6 py-3 font-semibold text-gray-100">{{ $item->name }}</td>
                            <td class="px-6 py-3">{{ $item->kelas }}</td>
                            <td class="px-6 py-3">{{ $item->alamat }}</td>
                            <td class="px-6 py-3">{{ $item->nama_orangtua }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.siswa.show', $item->id) }}"
                                        class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded-lg
                                text-gray-100 text-xs flex items-center gap-1">
                                        👁️ Lihat
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded-lg
                                text-gray-100 text-xs flex items-center gap-1">
                                            🗑 Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="px-6 py-3" colspan="7">Tidak ada data</td>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📱 Mobile Card View --}}
        <div class="md:hidden space-y-4">
            <div
                class="bg-gray-900/60 backdrop-blur-lg rounded-2xl p-4 border border-gray-700
            hover:border-gray-500 transition">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-bold text-gray-200">Syahdan</h3>
                    <span class="text-xs text-gray-500">#23110065</span>
                </div>
                <p class="text-sm"><span class="font-semibold text-gray-400">Kelas:</span> J2023</p>
                <p class="text-sm"><span class="font-semibold text-gray-400">Alamat:</span> Kopo</p>
                <p class="text-sm mb-3"><span class="font-semibold text-gray-400">No. Telp:</span> 08357</p>
                <div class="flex justify-end gap-2">

                    <button
                        class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded-lg
                    text-gray-100 text-xs">
                        Edit
                    </button>
                    <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST"
                        onsubmit="return confirm('Yakin mau hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded-lg
                    text-gray-100 text-xs cursor-pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL -->
    <div id="siswaModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm overflow-y-auto">

        <div
            class="bg-gray-900 w-full max-w-3xl mx-4 rounded-2xl shadow-2xl border border-gray-700 animate-scale max-h-[120vh]">

            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700">
                <h3 class="text-lg font-bold text-gray-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    </svg>
                    Form Data Siswa
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-400 transition">
                    ✕
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.siswa.store') }}" method="POST"
                class="p-6 space-y-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800">
                @csrf

                <!-- 🔐 Data Akun -->
                <div>
                    <h4 class="text-sm font-semibold text-indigo-400 mb-3">Data Akun</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-400">NIS</label>
                            <input type="text" name="nis"
                                class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none text-white"
                                placeholder="Masukkan NIS">
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Email</label>
                            <input type="email" name="email"
                                class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none text-white"
                                placeholder="Masukkan Email">
                        </div>
                    </div>
                </div>

                <!-- 👨‍🎓 Data Siswa -->
                <div>
                    <h4 class="text-sm font-semibold text-indigo-400 mb-3">Data Siswa</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-400">Nama Siswa</label>
                            <input type="text" name="nama"
                                class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none text-white"
                                placeholder="Nama lengkap">
                        </div>

                        <div>
                            <label class="text-sm text-gray-400">Kelas</label>
                            <input type="text" name="kelas"
                                class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none text-white"
                                placeholder="Contoh: J 2023">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-sm text-gray-400">Alamat</label>
                            <textarea name="alamat" rows="2"
                                class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none text-white"
                                placeholder="Alamat siswa"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 👪 Data Orang Tua -->
                <div>
                    <h4 class="text-sm font-semibold text-indigo-400 mb-3">Data Orang Tua</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-400">Nama Orang Tua</label>
                            <input type="text" name="nama_orangtua"
                                class="w-full mt-1 bg-gray-800 border border-gray-700 rounded-xl px-4 py-2
                            focus:ring-2 focus:ring-indigo-500 focus:outline-none text-white"
                                placeholder="Nama orang tua">
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-700">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 rounded-xl bg-gray-700 hover:bg-gray-600 text-white transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('siswaModal').classList.remove('hidden')
            document.getElementById('siswaModal').classList.add('flex')
        }

        function closeModal() {
            document.getElementById('siswaModal').classList.add('hidden')
            document.getElementById('siswaModal').classList.remove('flex')
        }
    </script>



@endsection
