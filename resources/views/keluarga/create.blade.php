@extends('layouts.member')

@section('title', 'Buat Rumpun Keluarga')

@section('content')

    <div class="max-w-4xl mx-auto">

        <div class="mb-8">

            <a href="{{ route('keluarga.pilih') }}" class="text-blue-600 text-sm">

                ← Kembali

            </a>

            <h2 class="text-3xl font-bold mt-4">
                Buat Rumpun Keluarga
            </h2>

            <p class="text-slate-500 mt-2">
                Lengkapi informasi dasar untuk membuat rumpun keluarga baru.
            </p>

        </div>

        <form method="POST" action="{{ route('keluarga.store') }}" enctype="multipart/form-data"
            class="bg-white border rounded-2xl p-8 space-y-6">
            @csrf


            <div>

                <label class="block font-medium mb-2">
                    Nama Rumpun Keluarga *
                </label>

                @error('nama_keluarga')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

                <input type="text" name="nama_keluarga" value="{{ old('nama_keluarga') }}"
                    placeholder="Contoh: Keluarga Besar Syamsul" class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block font-medium mb-2">
                    Asal Daerah
                </label>

                <input type="text" name="asal_daerah" value="{{ old('asal_daerah') }}"
                    placeholder="Contoh: Letta, Pinrang" class="w-full border rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="block font-medium mb-2">
                    Deskripsi
                </label>

                <textarea name="deskripsi" rows="4" class="w-full border rounded-xl px-4 py-3">{{ old('deskripsi') }}</textarea>

            </div>

            <div>

                <label class="block font-medium mb-2">
                    Foto Keluarga
                </label>

                <input type="file" name="foto" accept="image/*" class="w-full border rounded-xl px-4 py-3">

            </div>

            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('keluarga.pilih') }}" class="border px-6 py-3 rounded-xl">

                    Batal

                </a>

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold">

                    Buat Keluarga

                </button>

            </div>

        </form>

    </div>

@endsection
