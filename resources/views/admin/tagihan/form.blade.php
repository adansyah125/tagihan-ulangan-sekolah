@extends('admin.layouts.app')

@section('title', 'Tagihan UTS')

@section('content')
    <div id="modalAkses" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 border border-gray-700 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">

            <div class="p-6 flex items-center justify-between border-b border-gray-800">
                <h3 class="text-xl font-bold text-white">Konfigurasi Akses Tagihan</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-red-400">✕</button>
            </div>

            <form id="formAkses" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <div class="space-y-3">
                        <label class="text-sm font-medium text-gray-300 italic">Pilih Jangkauan:</label>

                        <label
                            class="group flex items-center justify-between p-3 rounded-xl border border-gray-700 hover:border-indigo-500 bg-gray-800/50 cursor-pointer transition">
                            <span class="text-gray-200 text-sm font-medium">Hanya Siswa Terkait</span>
                            <input type="radio" name="akses_pilihan" value="siswa" checked
                                class="w-4 h-4 text-indigo-600">
                        </label>

                        <label
                            class="group flex items-center justify-between p-3 rounded-xl border border-gray-700 hover:border-emerald-500 bg-gray-800/50 cursor-pointer transition">
                            <span class="text-gray-200 text-sm font-medium">Satu Kelas</span>
                            <input type="radio" name="akses_pilihan" value="kelas" class="w-4 h-4 text-emerald-600">
                        </label>

                        <label
                            class="group flex items-center justify-between p-3 rounded-xl border border-gray-700 hover:border-amber-500 bg-gray-800/50 cursor-pointer transition">
                            <span class="text-gray-200 text-sm font-medium">Seluruh Siswa</span>
                            <input type="radio" name="akses_pilihan" value="semua" class="w-4 h-4 text-amber-600">
                        </label>
                    </div>
                </div>

                <div class="p-6 bg-gray-800/30 grid grid-cols-2 gap-4">
                    <button type="submit" name="status" value="Tutup"
                        class="py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition">
                        Tutup Akses
                    </button>
                    <button type="submit" name="status" value="Buka"
                        class="py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition">
                        Buka Akses
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
