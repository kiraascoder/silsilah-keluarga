<x-app-layout>

    <div class="max-w-6xl mx-auto">

        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <div class="mb-7">

            <div class="flex items-center gap-2 text-sm mb-3">

                <a href="{{ route('anggota.index') }}"
                    class="text-blue-600 hover:text-blue-700 hover:underline">
                    Anggota Keluarga
                </a>

                <span class="text-slate-400">
                    ›
                </span>

                <span class="text-slate-500">
                    Detail Anggota
                </span>

            </div>


            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Detail Anggota
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Informasi lengkap anggota keluarga.
                    </p>
                </div>


                <div class="flex flex-wrap items-center gap-3">

                    <a href="{{ route('anggota.edit', $anggota->id) }}"
                        class="inline-flex items-center justify-center gap-2
                               bg-blue-600 hover:bg-blue-700
                               text-white rounded-xl
                               px-4 py-2.5
                               text-sm font-semibold
                               transition">

                        <i data-lucide="pencil" class="w-4 h-4"></i>

                        Edit Anggota

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
            ALERT
        ========================================================== --}}

        @if (session('success'))
            <div
                class="mb-6 rounded-xl
                       border border-green-200
                       bg-green-50
                       px-4 py-3
                       text-sm text-green-700">

                {{ session('success') }}

            </div>
        @endif


        @if (session('error'))
            <div
                class="mb-6 rounded-xl
                       border border-red-200
                       bg-red-50
                       px-4 py-3
                       text-sm text-red-700">

                {{ session('error') }}

            </div>
        @endif


        {{-- =========================================================
            INFORMASI UTAMA
        ========================================================== --}}

        <div
            class="bg-white
                   border border-slate-200
                   rounded-2xl
                   p-6 md:p-7
                   mb-6">

            <div
                class="flex flex-col
                       sm:flex-row
                       sm:items-start
                       gap-6">


                {{-- =================================================
                    FOTO
                ================================================== --}}

                <div class="shrink-0">

                    @if ($anggota->foto)

                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                            alt="{{ $anggota->nama_lengkap }}"
                            class="w-28 h-28 md:w-32 md:h-32
                                   rounded-2xl
                                   object-cover
                                   border border-slate-200
                                   shadow-sm">

                    @else

                        <div
                            class="w-28 h-28 md:w-32 md:h-32
                                   rounded-2xl
                                   bg-slate-100
                                   border border-slate-200
                                   flex items-center justify-center">

                            <i data-lucide="user"
                                class="w-12 h-12 text-slate-400">
                            </i>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    IDENTITAS
                ================================================== --}}

                <div class="min-w-0 flex-1">

                    {{-- Nama + badge --}}
                    <div
                        class="flex flex-col
                               sm:flex-row
                               sm:items-start
                               sm:justify-between
                               gap-4">

                        <div class="min-w-0">

                            <h2
                                class="text-2xl md:text-3xl
                                       font-bold
                                       text-slate-900
                                       break-words">

                                {{ $anggota->nama_lengkap }}

                            </h2>


                            {{-- Nama panggilan --}}
                            @if ($anggota->nama_panggilan)

                                <div
                                    class="flex flex-wrap
                                           items-center
                                           gap-2
                                           mt-2">

                                    <span class="text-sm text-slate-400">
                                        Nama panggilan
                                    </span>

                                    <span
                                        class="text-sm
                                               font-semibold
                                               text-slate-700">

                                        "{{ $anggota->nama_panggilan }}"

                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- Badge status --}}
                        <div
                            class="flex flex-wrap
                                   items-center
                                   gap-2
                                   shrink-0">

                            {{-- Status kehidupan --}}
                            @if ($anggota->status === 'meninggal')

                                <span
                                    class="inline-flex
                                           items-center
                                           rounded-full
                                           bg-slate-100
                                           px-3 py-1.5
                                           text-xs
                                           font-semibold
                                           text-slate-600">

                                    <span
                                        class="w-1.5 h-1.5
                                               rounded-full
                                               bg-slate-400
                                               mr-2">
                                    </span>

                                    Meninggal

                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           rounded-full
                                           bg-green-50
                                           px-3 py-1.5
                                           text-xs
                                           font-semibold
                                           text-green-700">

                                    <span
                                        class="w-1.5 h-1.5
                                               rounded-full
                                               bg-green-500
                                               mr-2">
                                    </span>

                                    Hidup

                                </span>

                            @endif


                            {{-- Status data --}}
                            @if ($anggota->status_data === 'aktif')

                                <span
                                    class="inline-flex
                                           items-center
                                           rounded-full
                                           bg-emerald-50
                                           px-3 py-1.5
                                           text-xs
                                           font-semibold
                                           text-emerald-700">

                                    <span
                                        class="w-1.5 h-1.5
                                               rounded-full
                                               bg-emerald-500
                                               mr-2">
                                    </span>

                                    Aktif

                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           rounded-full
                                           bg-red-50
                                           px-3 py-1.5
                                           text-xs
                                           font-semibold
                                           text-red-700">

                                    <span
                                        class="w-1.5 h-1.5
                                               rounded-full
                                               bg-red-500
                                               mr-2">
                                    </span>

                                    Tidak Aktif

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- Deskripsi --}}
                    @if ($anggota->deskripsi)

                        <div
                            class="mt-5
                                   max-w-3xl
                                   rounded-xl
                                   border border-blue-100
                                   bg-blue-50
                                   px-4 py-3">

                            <p
                                class="text-sm
                                       leading-6
                                       text-blue-900
                                       whitespace-pre-line">

                                {{ $anggota->deskripsi }}

                            </p>

                        </div>

                    @endif


                    {{-- Meta informasi --}}
                    <div
                        class="flex flex-wrap
                               items-center
                               gap-2
                               mt-5">

                        <span
                            class="inline-flex
                                   items-center
                                   gap-1.5
                                   rounded-lg
                                   bg-slate-100
                                   px-3 py-1.5
                                   text-xs
                                   text-slate-600">

                            <i data-lucide="users"
                                class="w-3.5 h-3.5">
                            </i>

                            Generasi {{ $anggota->generasi ?? '-' }}

                        </span>


                        <span
                            class="inline-flex
                                   items-center
                                   gap-1.5
                                   rounded-lg
                                   bg-slate-100
                                   px-3 py-1.5
                                   text-xs
                                   text-slate-600">

                            <i data-lucide="user"
                                class="w-3.5 h-3.5">
                            </i>

                            {{ ucfirst($anggota->jenis_kelamin) }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            INFORMASI PRIBADI
        ========================================================== --}}

        <div
            class="bg-white
                   border border-slate-200
                   rounded-2xl
                   p-6 md:p-7
                   mb-6">

            <div class="mb-6">

                <h2 class="text-lg font-bold text-slate-900">
                    Informasi Pribadi
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi dasar anggota keluarga.
                </p>

            </div>


            <div
                class="grid
                       grid-cols-1
                       sm:grid-cols-2
                       lg:grid-cols-3
                       gap-x-8
                       gap-y-6">


                {{-- Nama lengkap --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Nama Lengkap
                    </p>

                    <p class="font-medium text-slate-900 break-words">
                        {{ $anggota->nama_lengkap }}
                    </p>
                </div>


                {{-- Nama panggilan --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Nama Panggilan
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->nama_panggilan ?: '-' }}
                    </p>
                </div>


                {{-- Jenis kelamin --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Jenis Kelamin
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ ucfirst($anggota->jenis_kelamin) }}
                    </p>
                </div>


                {{-- Tempat lahir --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Tempat Lahir
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->tempat_lahir ?: '-' }}
                    </p>
                </div>


                {{-- Tanggal lahir --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Tanggal Lahir
                    </p>

                    <p class="font-medium text-slate-900">

                        @if ($anggota->tanggal_lahir)

                            {{ $anggota->tanggal_lahir->format('d F Y') }}

                        @else

                            -

                        @endif

                    </p>
                </div>


                {{-- Golongan darah --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Golongan Darah
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->golongan_darah ?: '-' }}
                    </p>
                </div>


                {{-- Generasi --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Generasi
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->generasi ?? '-' }}
                    </p>
                </div>


                {{-- Status kehidupan --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Status Kehidupan
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ ucfirst($anggota->status) }}
                    </p>
                </div>


                {{-- Status data --}}
                <div>
                    <p class="text-xs text-slate-400 mb-1">
                        Status Data
                    </p>

                    @if ($anggota->status_data === 'aktif')

                        <p class="font-medium text-emerald-600">
                            Aktif
                        </p>

                    @else

                        <p class="font-medium text-red-600">
                            Tidak Aktif
                        </p>

                    @endif

                </div>

            </div>

        </div>


        {{-- =========================================================
            HUBUNGAN KELUARGA
        ========================================================== --}}

        <div
            class="bg-white
                   border border-slate-200
                   rounded-2xl
                   p-6 md:p-7
                   mb-6">


            {{-- Header --}}
            <div
                class="flex flex-col
                       lg:flex-row
                       lg:items-center
                       lg:justify-between
                       gap-4
                       mb-6">

                <div>

                    <h2 class="text-lg font-bold text-slate-900">
                        Hubungan Keluarga
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Hubungan anggota dalam silsilah keluarga.
                    </p>

                </div>


                {{-- Tombol --}}
                <div
                    class="flex flex-wrap
                           items-center
                           gap-2">

                    <a href="{{ route('relasi.create', $anggota->id) }}"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               rounded-xl
                               bg-blue-600
                               px-4 py-2.5
                               text-sm
                               font-semibold
                               text-white
                               transition
                               hover:bg-blue-700">

                        <i data-lucide="plus"
                            class="h-4 w-4">
                        </i>

                        Tambah Hubungan

                    </a>


                    <a href="{{ route('pasangan.create', $anggota->id) }}"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               rounded-xl
                               bg-rose-600
                               px-4 py-2.5
                               text-sm
                               font-semibold
                               text-white
                               transition
                               hover:bg-rose-700">

                        <i data-lucide="heart"
                            class="h-4 w-4">
                        </i>

                        Tambah Pasangan

                    </a>

                </div>

            </div>


            {{-- =====================================================
                ORANG TUA + ANAK
            ====================================================== --}}

            <div
                class="grid
                       grid-cols-1
                       lg:grid-cols-2
                       gap-8">


                {{-- =================================================
                    ORANG TUA
                ================================================== --}}

                <div>

                    <div
                        class="flex
                               items-center
                               justify-between
                               mb-4">

                        <h3 class="font-semibold text-slate-900">
                            Orang Tua
                        </h3>

                        <span class="text-xs text-slate-400">
                            {{ $anggota->orangTua->count() }} data
                        </span>

                    </div>


                    @forelse($anggota->orangTua as $orangTua)

                        <div
                            class="flex
                                   items-center
                                   gap-3
                                   p-3
                                   rounded-xl
                                   border border-slate-200
                                   mb-2
                                   transition
                                   hover:bg-slate-50">

                            <a href="{{ route('anggota.show', $orangTua->id) }}"
                                class="flex
                                       items-center
                                       gap-3
                                       flex-1
                                       min-w-0">


                                {{-- Foto --}}
                                @if ($orangTua->foto)

                                    <img src="{{ asset('storage/' . $orangTua->foto) }}"
                                        alt="{{ $orangTua->nama_lengkap }}"
                                        class="w-10 h-10
                                               rounded-full
                                               object-cover
                                               shrink-0">

                                @else

                                    <div
                                        class="w-10 h-10
                                               rounded-full
                                               bg-slate-100
                                               flex items-center
                                               justify-center
                                               shrink-0">

                                        <i data-lucide="user"
                                            class="w-5 h-5 text-slate-400">
                                        </i>

                                    </div>

                                @endif


                                {{-- Informasi --}}
                                <div class="min-w-0">

                                    <p class="font-medium text-slate-900 truncate">
                                        {{ $orangTua->nama_lengkap }}
                                    </p>

                                    <p class="text-xs text-slate-500">

                                        {{ ucfirst($orangTua->pivot->jenis_hubungan) }}

                                        @if ($orangTua->status_data === 'tidak_aktif')
                                            <span class="text-red-500">
                                                · Tidak aktif
                                            </span>
                                        @endif

                                    </p>

                                </div>

                            </a>


                            {{-- Hapus relasi --}}
                            <form method="POST"
                                action="{{ route('relasi.destroy', $orangTua->pivot->id) }}"
                                onsubmit="return confirm('Hapus hubungan keluarga ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="p-2
                                           text-red-500
                                           hover:bg-red-50
                                           rounded-lg
                                           transition"
                                    title="Hapus hubungan">

                                    <i data-lucide="trash-2"
                                        class="w-4 h-4">
                                    </i>

                                </button>

                            </form>

                        </div>

                    @empty

                        <div
                            class="rounded-xl
                                   border border-dashed
                                   border-slate-300
                                   p-6
                                   text-center">

                            <i data-lucide="users"
                                class="w-7 h-7
                                       text-slate-300
                                       mx-auto
                                       mb-2">
                            </i>

                            <p class="text-sm text-slate-400">
                                Belum ada data orang tua.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- =================================================
                    ANAK
                ================================================== --}}

                <div>

                    <div
                        class="flex
                               items-center
                               justify-between
                               mb-4">

                        <h3 class="font-semibold text-slate-900">
                            Anak
                        </h3>

                        <span class="text-xs text-slate-400">
                            {{ $anggota->anak->count() }} data
                        </span>

                    </div>


                    @forelse($anggota->anak as $anak)

                        <div
                            class="flex
                                   items-center
                                   gap-3
                                   p-3
                                   rounded-xl
                                   border border-slate-200
                                   mb-2
                                   transition
                                   hover:bg-slate-50">

                            <a href="{{ route('anggota.show', $anak->id) }}"
                                class="flex
                                       items-center
                                       gap-3
                                       flex-1
                                       min-w-0">


                                {{-- Foto --}}
                                @if ($anak->foto)

                                    <img src="{{ asset('storage/' . $anak->foto) }}"
                                        alt="{{ $anak->nama_lengkap }}"
                                        class="w-10 h-10
                                               rounded-full
                                               object-cover
                                               shrink-0">

                                @else

                                    <div
                                        class="w-10 h-10
                                               rounded-full
                                               bg-slate-100
                                               flex items-center
                                               justify-center
                                               shrink-0">

                                        <i data-lucide="user"
                                            class="w-5 h-5 text-slate-400">
                                        </i>

                                    </div>

                                @endif


                                {{-- Informasi --}}
                                <div class="min-w-0">

                                    <p class="font-medium text-slate-900 truncate">
                                        {{ $anak->nama_lengkap }}
                                    </p>

                                    <p class="text-xs text-slate-500">

                                        Anak

                                        @if ($anak->status_data === 'tidak_aktif')

                                            <span class="text-red-500">
                                                · Tidak aktif
                                            </span>

                                        @endif

                                    </p>

                                </div>

                            </a>


                            {{-- Hapus relasi --}}
                            <form method="POST"
                                action="{{ route('relasi.destroy', $anak->pivot->id) }}"
                                onsubmit="return confirm('Hapus hubungan keluarga ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="p-2
                                           text-red-500
                                           hover:bg-red-50
                                           rounded-lg
                                           transition"
                                    title="Hapus hubungan">

                                    <i data-lucide="trash-2"
                                        class="w-4 h-4">
                                    </i>

                                </button>

                            </form>

                        </div>

                    @empty

                        <div
                            class="rounded-xl
                                   border border-dashed
                                   border-slate-300
                                   p-6
                                   text-center">

                            <i data-lucide="users"
                                class="w-7 h-7
                                       text-slate-300
                                       mx-auto
                                       mb-2">
                            </i>

                            <p class="text-sm text-slate-400">
                                Belum ada data anak.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- =====================================================
                PASANGAN
            ====================================================== --}}

            <div
                class="mt-8
                       pt-8
                       border-t border-slate-200">


                <div class="mb-4">

                    <h3 class="font-semibold text-slate-900">
                        Pasangan
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Hubungan pasangan anggota.
                    </p>

                </div>


                @php

                    $relasiPertama = $anggota->relasiPasanganPertama
                        ->map(function ($relasi) {

                            return [
                                'relasi' => $relasi,
                                'pasangan' => $relasi->anggotaKedua,
                            ];

                        })
                        ->values()
                        ->all();


                    $relasiKedua = $anggota->relasiPasanganKedua
                        ->map(function ($relasi) {

                            return [
                                'relasi' => $relasi,
                                'pasangan' => $relasi->anggotaPertama,
                            ];

                        })
                        ->values()
                        ->all();


                    $semuaRelasiPasangan = collect($relasiPertama)
                        ->merge($relasiKedua)
                        ->filter(function ($item) {

                            return $item['pasangan'] !== null;

                        })
                        ->sortBy(function ($item) {

                            return [
                                $item['relasi']->tanggal_mulai?->timestamp
                                    ?? PHP_INT_MAX,

                                $item['pasangan']->nama_lengkap,
                            ];

                        })
                        ->values();

                @endphp


                @if ($semuaRelasiPasangan->isNotEmpty())

                    <div class="space-y-3">

                        @foreach ($semuaRelasiPasangan as $item)

                            @php

                                $relasi = $item['relasi'];
                                $pasangan = $item['pasangan'];

                            @endphp


                            <div
                                class="rounded-xl
                                       border border-slate-200
                                       p-4
                                       transition
                                       hover:bg-slate-50">

                                <div
                                    class="flex
                                           items-start
                                           gap-3">


                                    {{-- Informasi pasangan --}}
                                    <a href="{{ route('anggota.show', $pasangan->id) }}"
                                        class="flex
                                               items-start
                                               gap-3
                                               flex-1
                                               min-w-0">


                                        {{-- Foto --}}
                                        @if ($pasangan->foto)

                                            <img src="{{ asset('storage/' . $pasangan->foto) }}"
                                                alt="{{ $pasangan->nama_lengkap }}"
                                                class="w-12 h-12
                                                       rounded-full
                                                       object-cover
                                                       shrink-0">

                                        @else

                                            <div
                                                class="w-12 h-12
                                                       rounded-full
                                                       bg-slate-100
                                                       flex items-center
                                                       justify-center
                                                       shrink-0">

                                                <i data-lucide="user"
                                                    class="w-5 h-5
                                                           text-slate-400">
                                                </i>

                                            </div>

                                        @endif


                                        <div class="min-w-0">

                                            {{-- Nama --}}
                                            <div
                                                class="flex
                                                       flex-wrap
                                                       items-center
                                                       gap-2">

                                                <p
                                                    class="font-semibold
                                                           text-slate-900
                                                           break-words">

                                                    {{ $pasangan->nama_lengkap }}

                                                </p>


                                                {{-- Status hubungan --}}
                                                <span
                                                    class="inline-flex
                                                           rounded-full
                                                           px-2.5 py-1
                                                           text-[11px]
                                                           font-semibold
                                                           shrink-0
                                                           {{ $relasi->status_hubungan === 'mantan'
                                                               ? 'bg-slate-100 text-slate-600'
                                                               : 'bg-emerald-50 text-emerald-700' }}">

                                                    {{ $relasi->status_hubungan === 'mantan'
                                                        ? 'Mantan Pasangan'
                                                        : 'Suami / Istri' }}

                                                </span>


                                                {{-- Status data pasangan --}}
                                                @if ($pasangan->status_data === 'tidak_aktif')

                                                    <span
                                                        class="inline-flex
                                                               rounded-full
                                                               bg-red-50
                                                               text-red-600
                                                               px-2.5 py-1
                                                               text-[11px]
                                                               font-semibold">

                                                        Tidak Aktif

                                                    </span>

                                                @endif

                                            </div>


                                            {{-- Generasi --}}
                                            <p
                                                class="text-xs
                                                       text-slate-500
                                                       mt-1">

                                                Generasi
                                                {{ $pasangan->generasi ?? '-' }}

                                            </p>


                                            {{-- Deskripsi --}}
                                            @if ($pasangan->deskripsi)

                                                <p
                                                    class="text-sm
                                                           text-slate-600
                                                           mt-2
                                                           leading-6
                                                           whitespace-pre-line">

                                                    {{ $pasangan->deskripsi }}

                                                </p>

                                            @endif


                                            {{-- Tanggal hubungan --}}
                                            @if ($relasi->tanggal_mulai || $relasi->tanggal_berakhir)

                                                <p
                                                    class="text-xs
                                                           text-slate-400
                                                           mt-2">

                                                    {{ $relasi->tanggal_mulai?->format('d/m/Y') ?? '-' }}

                                                    @if ($relasi->tanggal_berakhir)

                                                        —
                                                        {{ $relasi->tanggal_berakhir->format('d/m/Y') }}

                                                    @endif

                                                </p>

                                            @endif


                                            {{-- Catatan --}}
                                            @if ($relasi->catatan)

                                                <p
                                                    class="text-xs
                                                           text-slate-500
                                                           mt-2
                                                           whitespace-pre-line">

                                                    {{ $relasi->catatan }}

                                                </p>

                                            @endif

                                        </div>

                                    </a>


                                    {{-- Hapus pasangan --}}
                                    <form method="POST"
                                        action="{{ route('pasangan.destroy', $relasi->id) }}"
                                        onsubmit="return confirm('Hapus hubungan pasangan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="p-2
                                                   text-red-500
                                                   hover:bg-red-50
                                                   rounded-lg
                                                   transition"
                                            title="Hapus hubungan pasangan">

                                            <i data-lucide="trash-2"
                                                class="w-4 h-4">
                                            </i>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div
                        class="rounded-xl
                               border border-dashed
                               border-slate-300
                               p-6
                               text-center">

                        <i data-lucide="heart"
                            class="w-7 h-7
                                   text-slate-300
                                   mx-auto
                                   mb-2">
                        </i>

                        <p class="text-sm text-slate-400">
                            Belum ada data pasangan.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- =========================================================
            FOOTER ACTION
        ========================================================== --}}

        <div
            class="flex flex-col
                   sm:flex-row
                   sm:justify-between
                   sm:items-center
                   gap-4
                   pb-8">


            {{-- Kembali --}}
            <a href="{{ route('anggota.index') }}"
                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       border border-slate-300
                       rounded-xl
                       px-5 py-2.5
                       font-medium
                       text-slate-700
                       hover:bg-slate-50
                       transition">

                <i data-lucide="arrow-left"
                    class="w-4 h-4">
                </i>

                Kembali

            </a>


            {{-- Action --}}
            <div
                class="flex flex-wrap
                       items-center
                       justify-start
                       sm:justify-end
                       gap-2">


                {{-- Aktif / Nonaktif --}}
                @if ($anggota->status_data === 'aktif')

                    <form method="POST"
                        action="{{ route('anggota.destroy', $anggota->id) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan anggota ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   text-red-600
                                   hover:bg-red-50
                                   rounded-xl
                                   px-4 py-2.5
                                   font-medium
                                   transition">

                            <i data-lucide="user-x"
                                class="w-4 h-4">
                            </i>

                            Nonaktifkan Anggota

                        </button>

                    </form>

                @else

                    <form method="POST"
                        action="{{ route('anggota.aktifkan', $anggota->id) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan kembali anggota ini?')">

                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   text-emerald-600
                                   hover:bg-emerald-50
                                   rounded-xl
                                   px-4 py-2.5
                                   font-medium
                                   transition">

                            <i data-lucide="user-check"
                                class="w-4 h-4">
                            </i>

                            Aktifkan Kembali

                        </button>

                    </form>

                @endif


                {{-- Hapus permanen --}}
                <form method="POST"
                    action="{{ route('anggota.hapus-permanen', $anggota->id) }}"
                    onsubmit="return confirm('PERINGATAN: Data anggota, seluruh relasi orang tua/anak, relasi pasangan, dan dokumen terkait akan dihapus permanen. Lanjutkan?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               text-red-700
                               border border-red-200
                               hover:bg-red-50
                               rounded-xl
                               px-4 py-2.5
                               font-medium
                               transition">

                        <i data-lucide="trash-2"
                            class="w-4 h-4">
                        </i>

                        Hapus Permanen

                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
        LUCIDE
    ========================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        });
    </script>

</x-app-layout>
