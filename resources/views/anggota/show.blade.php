@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')

    <div class="space-y-6">

        <div>

            <a href="{{ route('anggota.index') }}" class="text-blue-600">
                Anggota Keluarga
            </a>

            <span class="mx-2">›</span>
            Detail Anggota

            <h2 class="text-3xl font-bold mt-3">
                Detail Anggota
            </h2>

        </div>

        <div class="bg-white border rounded-2xl p-7">

            <div class="flex justify-between">

                <div class="flex items-center gap-6">

                    <div class="w-28 h-28 rounded-full bg-slate-200 flex items-center justify-center">

                        <i data-lucide="user" class="w-14 h-14 text-slate-400"></i>

                    </div>

                    <div>

                        <div class="flex gap-3 items-center">

                            <h3 class="text-3xl font-bold">
                                Andi Syamsul
                            </h3>

                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg">
                                Kepala Keluarga
                            </span>

                        </div>

                        <div class="flex gap-5 mt-4 text-slate-600">

                            <span>14 Mei 1976</span>
                            <span>Laki-laki</span>
                            <span>Gol. Darah O</span>

                        </div>

                    </div>

                </div>

                <a href="{{ route('anggota.edit', 1) }}"
                    class="inline-flex items-center gap-2
           border border-slate-300 rounded-xl
           px-5 py-3 hover:bg-slate-50">

                    <i data-lucide="pencil" class="w-4 h-4"></i>

                    Edit Data
                </a>

            </div>

        </div>

        <div class="bg-white border rounded-2xl p-6">

            <h3 class="font-bold text-lg mb-6">
                Informasi Pribadi
            </h3>

            <div class="grid grid-cols-2 gap-y-5">

                <div>
                    <p class="text-slate-500">Nama Lengkap</p>
                    <p class="font-medium">Andi Syamsul</p>
                </div>

                <div>
                    <p class="text-slate-500">Nama Panggilan</p>
                    <p class="font-medium">Andi</p>
                </div>

                <div>
                    <p class="text-slate-500">Tempat Lahir</p>
                    <p class="font-medium">Makassar, Sulawesi Selatan</p>
                </div>

                <div>
                    <p class="text-slate-500">Tanggal Lahir</p>
                    <p class="font-medium">14 Mei 1976</p>
                </div>

                <div>
                    <p class="text-slate-500">Jenis Kelamin</p>
                    <p class="font-medium">Laki-laki</p>
                </div>

                <div>
                    <p class="text-slate-500">Golongan Darah</p>
                    <p class="font-medium">O</p>
                </div>

            </div>

        </div>

    </div>

@endsection
