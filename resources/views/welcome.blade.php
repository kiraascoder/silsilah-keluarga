@extends('layouts.guest')

@section('title', 'Beranda - Silsilahku')

@section('content')

    <section class="max-w-7xl mx-auto px-6 py-20">

        <div class="grid grid-cols-2 gap-14 items-center">

            <div>
                <span class="inline-block bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-sm font-medium mb-6">
                    Silsilah Keluarga Digital
                </span>

                <h1 class="text-5xl font-bold leading-tight mb-6">
                    Lestarikan Sejarah Keluarga dalam Satu Pohon Silsilah
                </h1>

                <p class="text-lg text-slate-500 leading-relaxed mb-8">
                    Catat anggota keluarga, hubungan kekerabatan, dan susun pohon silsilah
                    keluarga secara terstruktur dan mudah diakses.
                </p>

                <div class="flex gap-4">

                    <a href="{{ route('register') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">

                        Mulai Sekarang

                    </a>

                    <a href="{{ route('login') }}" class="border border-slate-300 px-6 py-3 rounded-xl font-semibold">

                        Masuk

                    </a>

                </div>
            </div>

            <div class="bg-slate-100 rounded-3xl p-12 min-h-[420px] flex items-center justify-center">

                <div class="text-center">

                    <div class="flex justify-center gap-6">

                        <div class="bg-white border rounded-xl px-6 py-4 shadow-sm">
                            <div class="w-12 h-12 bg-slate-200 rounded-full mx-auto mb-2"></div>
                            <strong>Kakek</strong>
                        </div>

                        <div class="bg-white border rounded-xl px-6 py-4 shadow-sm">
                            <div class="w-12 h-12 bg-slate-200 rounded-full mx-auto mb-2"></div>
                            <strong>Nenek</strong>
                        </div>

                    </div>

                    <div class="w-px h-10 bg-slate-400 mx-auto"></div>

                    <div class="flex justify-center gap-6">

                        <div class="bg-white border rounded-xl px-6 py-4">
                            <strong>Ayah</strong>
                        </div>

                        <div class="bg-white border rounded-xl px-6 py-4">
                            <strong>Ibu</strong>
                        </div>

                    </div>

                    <div class="w-px h-10 bg-slate-400 mx-auto"></div>

                    <div class="flex justify-center gap-4">

                        <div class="bg-white border rounded-xl px-5 py-3">
                            Anak 1
                        </div>

                        <div class="bg-white border rounded-xl px-5 py-3">
                            Anak 2
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="bg-white border-y border-slate-200">

        <div class="max-w-7xl mx-auto px-6 py-20">

            <div class="text-center max-w-2xl mx-auto mb-12">

                <h2 class="text-3xl font-bold">
                    Mengapa Menggunakan Silsilahku?
                </h2>

                <p class="text-slate-500 mt-3">
                    Kelola dan dokumentasikan sejarah keluarga dengan lebih mudah.
                </p>

            </div>

            <div class="grid grid-cols-3 gap-8">

                <div class="border rounded-2xl p-7">

                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-5">
                        <i data-lucide="git-fork"></i>
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        Pohon Silsilah
                    </h3>

                    <p class="text-slate-500">
                        Visualisasikan hubungan antaranggota keluarga dalam bentuk pohon.
                    </p>

                </div>

                <div class="border rounded-2xl p-7">

                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-5">
                        <i data-lucide="users"></i>
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        Data Terpusat
                    </h3>

                    <p class="text-slate-500">
                        Simpan informasi anggota keluarga dalam satu sistem yang terorganisasi.
                    </p>

                </div>

                <div class="border rounded-2xl p-7">

                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-5">
                        <i data-lucide="shield-check"></i>
                    </div>

                    <h3 class="font-bold text-lg mb-2">
                        Akses Keluarga
                    </h3>

                    <p class="text-slate-500">
                        Berikan akses kepada anggota keluarga melalui rumpun keluarga.
                    </p>

                </div>

            </div>

        </div>

    </section>

@endsection
