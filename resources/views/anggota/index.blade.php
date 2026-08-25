@extends('layouts.app')

@section('title', 'Anggota Keluarga')

@section('content')

    <div>

        <div class="flex justify-between items-end mb-6">

            <div>
                <h2 class="text-3xl font-bold">
                    Anggota Keluarga
                </h2>

                <p class="text-slate-500">
                    Kelola dan lihat daftar seluruh anggota keluarga dalam silsilah.
                </p>
            </div>

            <a href="{{ route('anggota.create') }}"
                class="bg-blue-600 text-white px-5 py-3 rounded-xl flex items-center gap-2">

                <i data-lucide="plus"></i>
                Tambah Anggota

            </a>

        </div>

        <div class="flex gap-4 mb-6">

            <input type="text" placeholder="Cari anggota..." class="border rounded-xl px-4 py-3 w-72">

            <select class="border rounded-xl px-4">
                <option>Semua Generasi</option>
            </select>

            <select class="border rounded-xl px-4">
                <option>Semua Peran</option>
            </select>

            <select class="border rounded-xl px-4">
                <option>Status: Aktif</option>
            </select>

        </div>

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

            <table class="w-full">

                <thead class="border-b bg-slate-50">
                    <tr>
                        <th class="text-left p-4">No</th>
                        <th class="text-left p-4">Nama</th>
                        <th class="text-left p-4">Peran</th>
                        <th class="text-left p-4">Tanggal Lahir</th>
                        <th class="text-left p-4">Generasi</th>
                        <th class="text-left p-4">Status</th>
                        <th class="text-left p-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $data = [
                            ['Andi Syamsul', 'Kepala Keluarga', '14 Mei 1976', 'Generasi 3'],
                            ['Dewi Rahman', 'Istri', '3 Maret 1980', 'Generasi 3'],
                            ['Muhammad Fadli', 'Anak', '5 Februari 2003', 'Generasi 4'],
                        ];
                    @endphp

                    @foreach ($data as $index => $item)
                        <tr class="border-b">

                            <td class="p-4">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-4 font-semibold">
                                {{ $item[0] }}
                            </td>

                            <td class="p-4">
                                {{ $item[1] }}
                            </td>

                            <td class="p-4">
                                {{ $item[2] }}
                            </td>

                            <td class="p-4">
                                {{ $item[3] }}
                            </td>

                            <td class="p-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                    Aktif
                                </span>
                            </td>

                            <td class="p-4">

                                <a href="{{ route('anggota.show', $index + 1) }}" class="inline-flex border rounded-lg p-2">

                                    <i data-lucide="eye" class="w-4 h-4"></i>

                                </a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@endsection
