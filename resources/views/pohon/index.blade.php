@extends('layouts.app')

@section('title', 'Pohon Silsilah')

@section('content')

    <div>

        <div class="flex justify-between items-end mb-6">

            <div>

                <h2 class="text-3xl font-bold">
                    Pohon Silsilah
                </h2>

                <p class="text-slate-500">
                    Lihat struktur dan hubungan keluarga Anda dalam bentuk pohon silsilah.
                </p>

            </div>

            <div class="flex gap-3">

                <button class="border px-4 py-3 rounded-lg">
                    Filter
                </button>

                <button class="border px-4 py-3 rounded-lg">
                    Export
                </button>

                <button class="bg-blue-600 text-white px-4 py-3 rounded-lg">
                    Cetak
                </button>

            </div>

        </div>

        <div class="bg-white border rounded-2xl p-8 min-h-[600px]">

            <div class="flex justify-center">

                <div class="text-center">

                    <div class="flex justify-center gap-8">

                        <div class="border rounded-xl p-5 w-52">
                            <strong>H. Abdul Rahman</strong>
                            <p class="text-sm">1945 - 2018</p>
                            <span class="text-xs">Kakek</span>
                        </div>

                        <div class="border rounded-xl p-5 w-52">
                            <strong>Hj. Siti Aisyah</strong>
                            <p class="text-sm">1948 - 2020</p>
                            <span class="text-xs">Nenek</span>
                        </div>

                    </div>

                    <div class="w-px h-12 bg-slate-400 mx-auto"></div>

                    <div class="flex justify-center gap-5">

                        <div class="border rounded-xl p-5">
                            Budi Rahman
                        </div>

                        <div class="border rounded-xl p-5">
                            Rina Rahman
                        </div>

                        <div class="border-2 border-blue-500 rounded-xl p-5">
                            Andi Syamsul
                        </div>

                    </div>

                    <div class="w-px h-12 bg-slate-400 mx-auto"></div>

                    <div class="flex justify-center gap-5">

                        <div class="border rounded-xl p-5">
                            Muhammad Fadli
                        </div>

                        <div class="border rounded-xl p-5">
                            Aisyah Putri
                        </div>

                        <div class="border rounded-xl p-5">
                            Fahri Syamsul
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
