@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')

    <div class="max-w-5xl">

        <div class="mb-7">

            <h2 class="text-3xl font-bold">
                Pengaturan Keluarga
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola informasi dan akses rumpun keluarga.
            </p>

        </div>


        {{-- Informasi keluarga --}}
        <div class="bg-white border border-slate-200
                rounded-2xl p-7 mb-6">

            <h3 class="text-lg font-bold">
                Informasi Keluarga
            </h3>

            <p class="text-sm text-slate-500 mt-1 mb-6">
                Informasi dasar rumpun keluarga.
            </p>


            <div class="space-y-5">

                <div>
                    <label class="block font-medium mb-2">
                        Nama Rumpun Keluarga
                    </label>

                    <input type="text" value="Keluarga Besar Syamsul"
                        class="w-full border border-slate-300
                           rounded-xl px-4 py-3">
                </div>


                <div>
                    <label class="block font-medium mb-2">
                        Asal Daerah
                    </label>

                    <input type="text" value="Makassar, Sulawesi Selatan"
                        class="w-full border border-slate-300
                           rounded-xl px-4 py-3">
                </div>


                <div>
                    <label class="block font-medium mb-2">
                        Deskripsi
                    </label>

                    <textarea rows="4" class="w-full border border-slate-300
                           rounded-xl px-4 py-3">Rumpun keluarga besar Syamsul.</textarea>
                </div>

            </div>


            <div class="flex justify-end mt-6">

                <button class="bg-blue-600 text-white
                       rounded-xl px-6 py-3 font-semibold">

                    Simpan Perubahan
                </button>

            </div>

        </div>


        {{-- Kode undangan --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-7">

            <div class="flex justify-between items-start">

                <div>

                    <h3 class="text-lg font-bold">
                        Undangan Keluarga
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Bagikan kode ini kepada anggota keluarga
                        yang ingin bergabung.
                    </p>

                </div>

                <div
                    class="w-12 h-12 bg-blue-50 text-blue-600
                        rounded-xl flex items-center justify-center">

                    <i data-lucide="mail"></i>

                </div>

            </div>


            <div class="mt-6">

                <label class="block text-sm font-medium mb-2">
                    Kode Undangan
                </label>

                <div class="flex gap-3">

                    <input id="kodeUndangan" type="text" value="SYAMSUL24" readonly
                        class="flex-1 bg-slate-50 border border-slate-300
                           rounded-xl px-4 py-3 font-semibold">

                    <button type="button" onclick="salinKode()"
                        class="border border-slate-300
                           rounded-xl px-5 py-3
                           flex items-center gap-2">

                        <i data-lucide="copy" class="w-4 h-4"></i>

                        Salin
                    </button>

                </div>

            </div>

        </div>

    </div>


    <script>
        function salinKode() {
            const input = document.getElementById('kodeUndangan');

            navigator.clipboard.writeText(input.value);
        }
    </script>

@endsection
