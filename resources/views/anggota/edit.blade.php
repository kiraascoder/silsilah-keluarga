@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')

    <div class="max-w-6xl">

        {{-- Breadcrumb --}}
        <div class="mb-7">
            <div class="flex items-center gap-2 text-sm mb-3">
                <a href="{{ route('anggota.index') }}" class="text-blue-600 hover:underline">
                    Anggota Keluarga
                </a>

                <span class="text-slate-400">›</span>

                <span class="text-slate-500">
                    Edit Anggota
                </span>
            </div>

            <h2 class="text-3xl font-bold">
                Edit Anggota
            </h2>

            <p class="text-slate-500 mt-1">
                Perbarui informasi anggota keluarga.
            </p>
        </div>


        <form class="space-y-6">

            {{-- Informasi Pribadi --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-7">

                <div class="mb-6">
                    <h3 class="text-lg font-bold">
                        Informasi Pribadi
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Informasi dasar anggota keluarga.
                    </p>
                </div>


                {{-- Foto --}}
                <div class="flex items-center gap-5 mb-8">

                    <div
                        class="w-24 h-24 bg-slate-100 rounded-full
                            flex items-center justify-center">

                        <i data-lucide="user" class="w-10 h-10 text-slate-400"></i>

                    </div>

                    <div>
                        <label for="foto"
                            class="inline-flex items-center gap-2 border
                               border-slate-300 rounded-lg px-4 py-2
                               cursor-pointer hover:bg-slate-50">

                            <i data-lucide="upload" class="w-4 h-4"></i>

                            Ganti Foto
                        </label>

                        <input type="file" id="foto" name="foto" class="hidden">

                        <p class="text-xs text-slate-400 mt-2">
                            JPG atau PNG, maksimal 2 MB.
                        </p>
                    </div>

                </div>


                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block font-medium mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" value="Andi Syamsul"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Nama Panggilan
                        </label>

                        <input type="text" value="Andi"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Tempat Lahir
                        </label>

                        <input type="text" value="Makassar"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Tanggal Lahir
                        </label>

                        <input type="date" value="1976-05-14"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Jenis Kelamin
                        </label>

                        <select class="w-full border border-slate-300
                               rounded-xl px-4 py-3">

                            <option selected>Laki-laki</option>
                            <option>Perempuan</option>

                        </select>
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Golongan Darah
                        </label>

                        <select class="w-full border border-slate-300
                               rounded-xl px-4 py-3">

                            <option>A</option>
                            <option>B</option>
                            <option>AB</option>
                            <option selected>O</option>

                        </select>
                    </div>

                </div>

            </div>


            {{-- Hubungan Keluarga --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-7">

                <div class="mb-6">
                    <h3 class="text-lg font-bold">
                        Hubungan Keluarga
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Tentukan posisi anggota di dalam silsilah.
                    </p>
                </div>


                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block font-medium mb-2">
                            Generasi
                        </label>

                        <select class="w-full border border-slate-300
                               rounded-xl px-4 py-3">

                            <option>Generasi 1</option>
                            <option>Generasi 2</option>
                            <option selected>Generasi 3</option>
                            <option>Generasi 4</option>

                        </select>
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Status
                        </label>

                        <select class="w-full border border-slate-300
                               rounded-xl px-4 py-3">

                            <option selected>Hidup</option>
                            <option>Meninggal</option>

                        </select>
                    </div>

                </div>

            </div>


            <div class="flex justify-end gap-3">

                <a href="{{ route('anggota.index') }}"
                    class="border border-slate-300 rounded-xl
                       px-6 py-3 font-medium hover:bg-slate-50">

                    Batal
                </a>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700
                       text-white rounded-xl px-6 py-3
                       font-semibold">

                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

@endsection
