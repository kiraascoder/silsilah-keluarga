<x-app-layout>

    <div class="max-w-6xl mx-auto">

        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <div class="mb-7">

            <div class="flex items-center gap-2 text-sm mb-3">

                <a href="{{ route('anggota.index') }}" class="text-blue-600 hover:underline">
                    Anggota Keluarga
                </a>

                <span class="text-slate-400">
                    ›
                </span>

                <span class="text-slate-500">
                    Detail Anggota
                </span>

            </div>


            <div
                class="flex flex-col
                       md:flex-row
                       md:items-center
                       md:justify-between
                       gap-4">

                <div>

                    <h1 class="text-3xl font-bold text-slate-900">
                        Detail Anggota
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Informasi lengkap anggota keluarga.
                    </p>

                </div>


                <div class="flex items-center gap-3">

                    <a href="{{ route('anggota.edit', $anggota->id) }}"
                        class="inline-flex
                               items-center
                               gap-2
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               rounded-xl
                               px-4
                               py-2.5
                               text-sm
                               font-semibold">

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
                class="mb-6
                       rounded-xl
                       border
                       border-green-200
                       bg-green-50
                       px-4
                       py-3
                       text-sm
                       text-green-700">

                {{ session('success') }}

            </div>
        @endif


        @if (session('error'))
            <div
                class="mb-6
                       rounded-xl
                       border
                       border-red-200
                       bg-red-50
                       px-4
                       py-3
                       text-sm
                       text-red-700">

                {{ session('error') }}

            </div>
        @endif



        {{-- =========================================================
            INFORMASI UTAMA
        ========================================================== --}}

        <div
            class="bg-white
                   border
                   border-slate-200
                   rounded-2xl
                   p-7
                   mb-6">

            <div
                class="flex flex-col
                       md:flex-row
                       md:items-center
                       gap-6">


                {{-- FOTO --}}

                <div class="shrink-0">

                    @if ($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                            alt="{{ $anggota->nama_lengkap }}"
                            class="w-28 h-28
                                   rounded-full
                                   object-cover
                                   border
                                   border-slate-200">
                    @else
                        <div
                            class="w-28 h-28
                                   rounded-full
                                   bg-slate-100
                                   flex
                                   items-center
                                   justify-center">

                            <i data-lucide="user"
                                class="w-12 h-12
                                       text-slate-400"></i>

                        </div>
                    @endif

                </div>



                {{-- IDENTITAS --}}

                <div class="flex-1">

                    <div
                        class="flex flex-wrap
                               items-center
                               gap-2
                               mb-2">

                        <h2
                            class="text-2xl
                                   font-bold
                                   text-slate-900">
                            {{ $anggota->nama_lengkap }}
                        </h2>


                        @if ($anggota->status === 'meninggal')
                            <span
                                class="inline-flex
                                       items-center
                                       rounded-full
                                       bg-slate-100
                                       px-3
                                       py-1
                                       text-xs
                                       font-medium
                                       text-slate-600">
                                Meninggal
                            </span>
                        @else
                            <span
                                class="inline-flex
                                       items-center
                                       rounded-full
                                       bg-green-50
                                       px-3
                                       py-1
                                       text-xs
                                       font-medium
                                       text-green-700">
                                Hidup
                            </span>
                        @endif

                    </div>


                    @if ($anggota->nama_panggilan)
                        <p class="text-slate-500 mb-4">
                            {{ $anggota->nama_panggilan }}
                        </p>
                    @endif


                    <div class="flex flex-wrap
                               gap-2">

                        <span
                            class="inline-flex
                                   items-center
                                   gap-1.5
                                   rounded-lg
                                   bg-slate-100
                                   px-3
                                   py-1.5
                                   text-xs
                                   text-slate-600">

                            <i data-lucide="users" class="w-3.5 h-3.5"></i>

                            Generasi {{ $anggota->generasi }}

                        </span>


                        <span
                            class="inline-flex
                                   items-center
                                   gap-1.5
                                   rounded-lg
                                   bg-slate-100
                                   px-3
                                   py-1.5
                                   text-xs
                                   text-slate-600">

                            <i data-lucide="user" class="w-3.5 h-3.5"></i>

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
                   border
                   border-slate-200
                   rounded-2xl
                   p-7
                   mb-6">

            <div class="mb-6">

                <h2 class="text-lg font-bold">
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
                       gap-6">

                {{-- Nama Lengkap --}}

                <div>

                    <p class="text-xs text-slate-400 mb-1">
                        Nama Lengkap
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->nama_lengkap }}
                    </p>

                </div>


                {{-- Nama Panggilan --}}

                <div>

                    <p class="text-xs text-slate-400 mb-1">
                        Nama Panggilan
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->nama_panggilan ?: '-' }}
                    </p>

                </div>


                {{-- Jenis Kelamin --}}

                <div>

                    <p class="text-xs text-slate-400 mb-1">
                        Jenis Kelamin
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ ucfirst($anggota->jenis_kelamin) }}
                    </p>

                </div>


                {{-- Tempat Lahir --}}

                <div>

                    <p class="text-xs text-slate-400 mb-1">
                        Tempat Lahir
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ $anggota->tempat_lahir ?: '-' }}
                    </p>

                </div>


                {{-- Tanggal Lahir --}}

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


                {{-- Golongan Darah --}}

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
                        {{ $anggota->generasi }}
                    </p>

                </div>


                {{-- Status --}}

                <div>

                    <p class="text-xs text-slate-400 mb-1">
                        Status
                    </p>

                    <p class="font-medium text-slate-900">
                        {{ ucfirst($anggota->status) }}
                    </p>

                </div>

            </div>

        </div>



        {{-- =========================================================
            HUBUNGAN KELUARGA
        ========================================================== --}}

        <div
            class="bg-white
                   border
                   border-slate-200
                   rounded-2xl
                   p-7
                   mb-6">

            <div
                class="flex flex-col
                       sm:flex-row
                       sm:items-center
                       sm:justify-between
                       gap-4
                       mb-6">

                <div>

                    <h2 class="text-lg font-bold">
                        Hubungan Keluarga
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Hubungan anggota dalam silsilah keluarga.
                    </p>

                </div>


                <a href="{{ route('relasi.create', $anggota->id) }}"
                    class="inline-flex
                           items-center
                           justify-center
                           gap-2
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           rounded-xl
                           px-4
                           py-2.5
                           text-sm
                           font-semibold">

                    <i data-lucide="plus" class="w-4 h-4"></i>

                    Tambah Hubungan

                </a>

            </div>



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

                        <h3 class="font-semibold">
                            Orang Tua
                        </h3>

                        <span class="text-xs
                                   text-slate-400">
                            {{ $anggota->orangTua->count() }}
                            data
                        </span>

                    </div>


                    @forelse($anggota->orangTua
                        as $orangTua)
                        <div
                            class="flex
                                   items-center
                                   gap-3
                                   p-3
                                   rounded-xl
                                   border
                                   border-slate-200
                                   mb-2
                                   hover:bg-slate-50">

                            <a href="{{ route('anggota.show', $orangTua->id) }}"
                                class="flex
                                       items-center
                                       gap-3
                                       flex-1
                                       min-w-0">

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
                                               flex
                                               items-center
                                               justify-center
                                               shrink-0">

                                        <i data-lucide="user"
                                            class="w-5 h-5
                                                   text-slate-400"></i>

                                    </div>
                                @endif


                                <div class="min-w-0">

                                    <p class="font-medium
                                               truncate">
                                        {{ $orangTua->nama_lengkap }}
                                    </p>

                                    <p class="text-xs
                                               text-slate-500">
                                        {{ ucfirst($orangTua->pivot->jenis_hubungan) }}
                                    </p>

                                </div>

                            </a>


                            <form method="POST"
                                action="{{ route('relasi.destroy', $orangTua->pivot->id) }}"
                                onsubmit="return confirm(
                                    'Hapus hubungan keluarga ini?'
                                )">

                                @csrf

                                @method('DELETE')

                                <button type="submit"
                                    class="p-2
                                           text-red-500
                                           hover:bg-red-50
                                           rounded-lg"
                                    title="Hapus hubungan">

                                    <i data-lucide="trash-2" class="w-4 h-4"></i>

                                </button>

                            </form>

                        </div>

                    @empty

                        <div
                            class="rounded-xl
                                   border
                                   border-dashed
                                   border-slate-300
                                   p-6
                                   text-center">

                            <i data-lucide="users"
                                class="w-7 h-7
                                       text-slate-300
                                       mx-auto
                                       mb-2"></i>

                            <p class="text-sm
                                       text-slate-400">
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

                        <h3 class="font-semibold">
                            Anak
                        </h3>

                        <span class="text-xs
                                   text-slate-400">
                            {{ $anggota->anak->count() }}
                            data
                        </span>

                    </div>


                    @forelse($anggota->anak
                        as $anak)
                        <div
                            class="flex
                                   items-center
                                   gap-3
                                   p-3
                                   rounded-xl
                                   border
                                   border-slate-200
                                   mb-2
                                   hover:bg-slate-50">

                            <a href="{{ route('anggota.show', $anak->id) }}"
                                class="flex
                                       items-center
                                       gap-3
                                       flex-1
                                       min-w-0">

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
                                               flex
                                               items-center
                                               justify-center
                                               shrink-0">

                                        <i data-lucide="user"
                                            class="w-5 h-5
                                                   text-slate-400"></i>

                                    </div>
                                @endif


                                <div class="min-w-0">

                                    <p class="font-medium
                                               truncate">
                                        {{ $anak->nama_lengkap }}
                                    </p>

                                    <p class="text-xs
                                               text-slate-500">
                                        Anak
                                    </p>

                                </div>

                            </a>


                            <form method="POST"
                                action="{{ route('relasi.destroy', $anak->pivot->id) }}"
                                onsubmit="return confirm(
                                    'Hapus hubungan keluarga ini?'
                                )">

                                @csrf

                                @method('DELETE')

                                <button type="submit"
                                    class="p-2
                                           text-red-500
                                           hover:bg-red-50
                                           rounded-lg"
                                    title="Hapus hubungan">

                                    <i data-lucide="trash-2" class="w-4 h-4"></i>

                                </button>

                            </form>

                        </div>

                    @empty

                        <div
                            class="rounded-xl
                                   border
                                   border-dashed
                                   border-slate-300
                                   p-6
                                   text-center">

                            <i data-lucide="users"
                                class="w-7 h-7
                                       text-slate-300
                                       mx-auto
                                       mb-2"></i>

                            <p class="text-sm
                                       text-slate-400">
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
                       border-t
                       border-slate-200">

                <div class="mb-4">

                    <h3 class="font-semibold">
                        Pasangan
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Hubungan pasangan anggota.
                    </p>

                </div>


                @php

                    $pasangan = null;

                    if ($anggota->relasiPasanganPertama->isNotEmpty()) {
                        $pasangan = $anggota->relasiPasanganPertama->first()->anggotaKedua;
                    } elseif ($anggota->relasiPasanganKedua->isNotEmpty()) {
                        $pasangan = $anggota->relasiPasanganKedua->first()->anggotaPertama;
                    }

                @endphp


                @if ($pasangan)

                    <div
                        class="flex
                               items-center
                               gap-3
                               p-3
                               rounded-xl
                               border
                               border-slate-200
                               hover:bg-slate-50">

                        <a href="{{ route('anggota.show', $pasangan->id) }}"
                            class="flex
                                   items-center
                                   gap-3
                                   flex-1">

                            @if ($pasangan->foto)
                                <img src="{{ asset('storage/' . $pasangan->foto) }}"
                                    alt="{{ $pasangan->nama_lengkap }}"
                                    class="w-12 h-12
                                           rounded-full
                                           object-cover">
                            @else
                                <div
                                    class="w-12 h-12
                                           rounded-full
                                           bg-slate-100
                                           flex
                                           items-center
                                           justify-center">

                                    <i data-lucide="user"
                                        class="w-5 h-5
                                               text-slate-400"></i>

                                </div>
                            @endif


                            <div>

                                <p class="font-medium">
                                    {{ $pasangan->nama_lengkap }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    Pasangan
                                </p>

                            </div>

                        </a>

                    </div>
                @else
                    <div
                        class="rounded-xl
                               border
                               border-dashed
                               border-slate-300
                               p-6
                               text-center">

                        <i data-lucide="heart"
                            class="w-7 h-7
                                   text-slate-300
                                   mx-auto
                                   mb-2"></i>

                        <p class="text-sm
                                   text-slate-400">
                            Belum ada data pasangan.
                        </p>

                    </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
            FOOTER ACTION
        ========================================================== --}}

        <div class="flex
                   justify-between
                   items-center
                   gap-3">

            <a href="{{ route('anggota.index') }}"
                class="inline-flex
                       items-center
                       gap-2
                       border
                       border-slate-300
                       rounded-xl
                       px-5
                       py-2.5
                       font-medium
                       hover:bg-slate-50">

                <i data-lucide="arrow-left" class="w-4 h-4"></i>

                Kembali

            </a>


            <form method="POST"
                action="{{ route('anggota.destroy', $anggota->id) }}"
                onsubmit="return confirm(
                    'Apakah Anda yakin ingin menonaktifkan anggota ini?'
                )">

                @csrf

                @method('DELETE')

                <button type="submit"
                    class="inline-flex
                           items-center
                           gap-2
                           text-red-600
                           hover:bg-red-50
                           rounded-xl
                           px-4
                           py-2.5
                           font-medium">

                    <i data-lucide="user-x" class="w-4 h-4"></i>

                    Nonaktifkan Anggota

                </button>

            </form>

        </div>

    </div>


    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>

</x-app-layout>
