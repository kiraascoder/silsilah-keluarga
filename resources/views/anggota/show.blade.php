{{-- Hubungan Keluarga --}}

<div class="bg-white border border-slate-200 rounded-2xl p-7 mt-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>

            <h3 class="text-lg font-bold">
                Hubungan Keluarga
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Hubungan anggota dalam silsilah keluarga.
            </p>

        </div>


        <a href="{{ route('pasangan.create', $anggota->id) }}"
            class="inline-flex items-center gap-2
           border border-slate-300
           rounded-xl px-4 py-2
           text-sm font-semibold
           hover:bg-slate-50">

            <i data-lucide="heart" class="w-4 h-4"></i>

            Tambah Pasangan

        </a>

    </div>




    {{-- Isi Hubungan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


        {{-- ===================================================== --}}
        {{-- ORANG TUA --}}
        {{-- ===================================================== --}}

        <div>

            <h4 class="font-semibold mb-3">
                Orang Tua
            </h4>


            @forelse($anggota->orangTua as $orangTua)
                <div
                    class="flex items-center gap-3
                           p-3 rounded-xl
                           border border-slate-200
                           mb-2">


                    {{-- Data orang tua --}}

                    <a href="{{ route('anggota.show', $orangTua->id) }}" class="flex items-center gap-3 flex-1 min-w-0">


                        {{-- Foto --}}

                        @if ($orangTua->foto)
                            <img src="{{ asset('storage/' . $orangTua->foto) }}" alt="{{ $orangTua->nama_lengkap }}"
                                class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        @else
                            <div
                                class="w-10 h-10 bg-slate-100
                                       rounded-full
                                       flex items-center justify-center
                                       flex-shrink-0">

                                <i data-lucide="user" class="w-5 h-5 text-slate-400">
                                </i>

                            </div>
                        @endif


                        {{-- Informasi --}}

                        <div class="min-w-0">

                            <p class="font-medium truncate">

                                {{ $orangTua->nama_lengkap }}

                            </p>


                            <p class="text-xs text-slate-500">

                                {{ ucfirst($orangTua->pivot->jenis_hubungan) }}

                            </p>

                        </div>

                    </a>



                    {{-- Hapus hubungan --}}

                    <form method="POST" action="{{ route('relasi.destroy', $orangTua->pivot->id) }}"
                        onsubmit="return confirm('Hapus hubungan dengan {{ $orangTua->nama_lengkap }}?')">

                        @csrf

                        @method('DELETE')


                        <button type="submit"
                            class="p-2 text-red-500
                                   hover:bg-red-50
                                   rounded-lg"
                            title="Hapus hubungan">

                            <i data-lucide="trash-2" class="w-4 h-4">
                            </i>

                        </button>

                    </form>


                </div>


            @empty

                <div
                    class="border border-dashed border-slate-300
                           rounded-xl p-5 text-center">

                    <i data-lucide="users" class="w-6 h-6 text-slate-300 mx-auto">
                    </i>

                    <p class="text-sm text-slate-400 mt-2">

                        Belum ada data orang tua.

                    </p>

                </div>
            @endforelse

        </div>



        {{-- ===================================================== --}}
        {{-- ANAK --}}
        {{-- ===================================================== --}}

        <div>

            <h4 class="font-semibold mb-3">
                Anak
            </h4>


            @forelse($anggota->anak as $anak)
                <div
                    class="flex items-center gap-3
                           p-3 rounded-xl
                           border border-slate-200
                           mb-2">


                    {{-- Data anak --}}

                    <a href="{{ route('anggota.show', $anak->id) }}" class="flex items-center gap-3 flex-1 min-w-0">


                        {{-- Foto --}}

                        @if ($anak->foto)
                            <img src="{{ asset('storage/' . $anak->foto) }}" alt="{{ $anak->nama_lengkap }}"
                                class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        @else
                            <div
                                class="w-10 h-10 bg-slate-100
                                       rounded-full
                                       flex items-center justify-center
                                       flex-shrink-0">

                                <i data-lucide="user" class="w-5 h-5 text-slate-400">
                                </i>

                            </div>
                        @endif


                        {{-- Informasi --}}

                        <div class="min-w-0">

                            <p class="font-medium truncate">

                                {{ $anak->nama_lengkap }}

                            </p>


                            <p class="text-xs text-slate-500">

                                Anak

                            </p>

                        </div>

                    </a>



                    {{-- Hapus hubungan --}}

                    <form method="POST" action="{{ route('relasi.destroy', $anak->pivot->id) }}"
                        onsubmit="return confirm('Hapus hubungan dengan {{ $anak->nama_lengkap }}?')">

                        @csrf

                        @method('DELETE')


                        <button type="submit"
                            class="p-2 text-red-500
                                   hover:bg-red-50
                                   rounded-lg"
                            title="Hapus hubungan">

                            <i data-lucide="trash-2" class="w-4 h-4">
                            </i>

                        </button>

                    </form>


                </div>
                {{-- Pasangan --}}

                {{-- Pasangan --}}

                <div class="mt-6">

                    <div class="flex items-center justify-between mb-3">

                        <h4 class="font-semibold">
                            Pasangan
                        </h4>

                        @if (!$anggota->pasangan)
                            <a href="{{ route('pasangan.create', $anggota->id) }}"
                                class="inline-flex items-center gap-2
                       border border-slate-300
                       rounded-lg px-3 py-2
                       text-sm font-medium
                       hover:bg-slate-50">

                                <i data-lucide="plus" class="w-4 h-4">
                                </i>

                                Tambah

                            </a>
                        @endif

                    </div>


                    @if ($anggota->pasangan)
                        <div
                            class="flex items-center gap-3
                   p-3 rounded-xl
                   border border-slate-200">


                            {{-- Data pasangan --}}

                            <a href="{{ route('anggota.show', $anggota->pasangan->id) }}"
                                class="flex items-center gap-3 flex-1 min-w-0">


                                @if ($anggota->pasangan->foto)
                                    <img src="{{ asset('storage/' . $anggota->pasangan->foto) }}"
                                        alt="{{ $anggota->pasangan->nama_lengkap }}"
                                        class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                @else
                                    <div
                                        class="w-10 h-10 bg-slate-100
                               rounded-full
                               flex items-center justify-center
                               flex-shrink-0">

                                        <i data-lucide="user" class="w-5 h-5 text-slate-400">
                                        </i>

                                    </div>
                                @endif


                                <div class="min-w-0">

                                    <p class="font-medium truncate">

                                        {{ $anggota->pasangan->nama_lengkap }}

                                    </p>

                                    <p class="text-xs text-slate-500">
                                        Pasangan
                                    </p>

                                </div>

                            </a>


                            {{-- Hapus pasangan --}}

                            @php

                                $relasiPasangan = $anggota->pasanganSebagaiPertama
                                    ->where('anggota_kedua_id', $anggota->pasangan->id)
                                    ->first();

                                if (!$relasiPasangan) {
                                    $relasiPasangan = $anggota->pasanganSebagaiKedua
                                        ->where('anggota_pertama_id', $anggota->pasangan->id)
                                        ->first();
                                }

                            @endphp


                            @if ($relasiPasangan)
                                <form method="POST" action="{{ route('pasangan.destroy', $relasiPasangan->id) }}"
                                    onsubmit="return confirm('Hapus hubungan pasangan ini?')">

                                    @csrf

                                    @method('DELETE')


                                    <button type="submit"
                                        class="p-2 text-red-500
                               hover:bg-red-50
                               rounded-lg"
                                        title="Hapus pasangan">

                                        <i data-lucide="trash-2" class="w-4 h-4">
                                        </i>

                                    </button>

                                </form>
                            @endif

                        </div>
                    @else
                        <div
                            class="border border-dashed border-slate-300
                   rounded-xl p-5 text-center">

                            <i data-lucide="heart" class="w-6 h-6 text-slate-300 mx-auto">
                            </i>

                            <p class="text-sm text-slate-400 mt-2">
                                Belum ada data pasangan.
                            </p>

                        </div>
                    @endif

                </div>

            @empty

                <div
                    class="border border-dashed border-slate-300
                           rounded-xl p-5 text-center">

                    <i data-lucide="users" class="w-6 h-6 text-slate-300 mx-auto">
                    </i>

                    <p class="text-sm text-slate-400 mt-2">

                        Belum ada data anak.

                    </p>

                </div>
            @endforelse

        </div>


    </div>

</div>
