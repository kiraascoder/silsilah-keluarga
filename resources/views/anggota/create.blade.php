@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')

    <div class="max-w-6xl">

        <div class="mb-6">

            <a href="{{ route('anggota.index') }}" class="text-blue-600">
                Anggota Keluarga
            </a>

            <span class="mx-2">›</span>

            <span>Tambah Anggota</span>

            <h2 class="text-3xl font-bold mt-3">
                Tambah Anggota
            </h2>

            <p class="text-slate-500">
                Lengkapi informasi untuk menambahkan anggota keluarga baru.
            </p>

        </div>

        <form class="space-y-6">

            <div class="bg-white border rounded-2xl p-6">

                <h3 class="font-bold text-lg mb-5">
                    Informasi Pribadi
                </h3>

                <div class="grid grid-cols-3 gap-5">

                    <div>
                        <label class="block mb-2">Nama Lengkap *</label>
                        <input class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2">Nama Panggilan</label>
                        <input class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2">Tanggal Lahir</label>
                        <input type="date" class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2">Jenis Kelamin *</label>

                        <select class="w-full border rounded-lg px-4 py-3">
                            <option>Pilih jenis kelamin</option>
                            <option>Laki-laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2">Golongan Darah</label>

                        <select class="w-full border rounded-lg px-4 py-3">
                            <option>Pilih golongan darah</option>
                            <option>A</option>
                            <option>B</option>
                            <option>AB</option>
                            <option>O</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2">Tempat Lahir</label>
                        <input class="w-full border rounded-lg px-4 py-3">
                    </div>

                </div>

            </div>

            <div class="bg-white border rounded-2xl p-6">

                <h3 class="font-bold text-lg mb-5">
                    Peran dalam Keluarga
                </h3>

                <div class="grid grid-cols-3 gap-5">

                    <select class="border rounded-lg px-4 py-3">
                        <option>Pilih peran</option>
                    </select>

                    <select class="border rounded-lg px-4 py-3">
                        <option>Pilih hubungan</option>
                    </select>

                    <select class="border rounded-lg px-4 py-3">
                        <option>Pilih generasi</option>
                    </select>

                </div>

            </div>

            <div class="flex justify-end gap-3">

                <a href="{{ route('anggota.index') }}" class="border px-5 py-3 rounded-lg">

                    Batal

                </a>

                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg">

                    Simpan Anggota

                </button>

            </div>

        </form>

    </div>

@endsection
