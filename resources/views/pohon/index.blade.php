@extends('layouts.member')

@section('title', 'Pohon Silsilah')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Header --}}

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-slate-900">
            Pohon Silsilah
        </h1>

        <p class="text-slate-500 mt-1">
            Lihat hubungan anggota dalam keluarga
            {{ $keluargaAktif->nama_keluarga }}.
        </p>

    </div>


    {{-- Anggota utama --}}

    @if($anggotaUtama)

        <div
            class="bg-white
                   border border-slate-200
                   rounded-2xl
                   p-6
                   mb-6"
        >

            <p
                class="text-xs
                       uppercase
                       tracking-wide
                       text-slate-400
                       mb-2"
            >
                Kepala / Titik Utama
            </p>


            <div class="flex items-center gap-4">

                @if($anggotaUtama->foto)

                    <img
                        src="{{ asset('storage/' . $anggotaUtama->foto) }}"
                        class="w-16 h-16 rounded-full object-cover"
                        alt="{{ $anggotaUtama->nama_lengkap }}"
                    >

                @else

                    <div
                        class="w-16 h-16
                               rounded-full
                               bg-slate-100
                               flex items-center
                               justify-center"
                    >

                        <i
                            data-lucide="user"
                            class="w-7 h-7 text-slate-400"
                        ></i>

                    </div>

                @endif


                <div>

                    <h2 class="text-lg font-bold">
                        {{ $anggotaUtama->nama_lengkap }}
                    </h2>

                    <p class="text-sm text-slate-500">
                        Generasi {{ $anggotaUtama->generasi }}
                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- Daftar struktur --}}

    <div
        class="bg-white
               border border-slate-200
               rounded-2xl
               overflow-hidden"
    >

        <div class="p-6 border-b border-slate-200">

            <h2 class="font-bold text-lg">
                Struktur Keluarga
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                {{ $anggota->count() }}
                anggota terdaftar.
            </p>

        </div>


        <div class="divide-y divide-slate-100">

            @forelse($anggota as $item)

                <div
                    class="p-5
                           flex
                           items-center
                           justify-between
                           hover:bg-slate-50"
                >

                    <div class="flex items-center gap-4">

                        @if($item->foto)

                            <img
                                src="{{ asset('storage/' . $item->foto) }}"
                                class="w-12 h-12
                                       rounded-full
                                       object-cover"
                                alt="{{ $item->nama_lengkap }}"
                            >

                        @else

                            <div
                                class="w-12 h-12
                                       rounded-full
                                       bg-slate-100
                                       flex items-center
                                       justify-center"
                            >

                                <i
                                    data-lucide="user"
                                    class="w-5 h-5
                                           text-slate-400"
                                ></i>

                            </div>

                        @endif


                        <div>

                            <a
                                href="{{ route('anggota.show', $item->id) }}"
                                class="font-semibold
                                       text-slate-900
                                       hover:text-blue-600"
                            >
                                {{ $item->nama_lengkap }}
                            </a>

                            <p class="text-sm text-slate-500">
                                Generasi {{ $item->generasi }}
                                ·
                                {{ ucfirst($item->jenis_kelamin) }}
                            </p>

                        </div>

                    </div>


                    <div class="text-right">

                        <p class="text-xs text-slate-400">
                            Orang tua
                        </p>

                        <p class="text-sm font-medium">
                            {{ $item->orangTua->count() }}
                        </p>

                    </div>


                    <div class="text-right">

                        <p class="text-xs text-slate-400">
                            Anak
                        </p>

                        <p class="text-sm font-medium">
                            {{ $item->anak->count() }}
                        </p>

                    </div>


                    <div class="text-right">

                        <p class="text-xs text-slate-400">
                            Pasangan
                        </p>

                        <p class="text-sm font-medium">
                            {{ $item->pasangan?->nama_lengkap ?? '-' }}
                        </p>

                    </div>

                </div>

            @empty

                <div class="p-12 text-center">

                    <i
                        data-lucide="users"
                        class="w-10 h-10
                               text-slate-300
                               mx-auto
                               mb-3"
                    ></i>

                    <p class="font-medium text-slate-600">
                        Belum ada anggota keluarga.
                    </p>

                    <p class="text-sm text-slate-400 mt-1">
                        Tambahkan anggota terlebih dahulu
                        untuk membangun silsilah.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

<script>
    lucide.createIcons();
</script>

@endsection
