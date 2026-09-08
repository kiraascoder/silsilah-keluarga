<x-app-layout>

    <div class="max-w-7xl">

        {{-- Header --}}

        <div class="mb-7">

            <h1 class="text-3xl font-bold">
                Pohon Silsilah
            </h1>

            <p class="text-slate-500 mt-1">
                Struktur hubungan anggota keluarga berdasarkan data silsilah.
            </p>

        </div>


        {{-- Informasi --}}

        @if (config('app.debug'))
            <div class="bg-slate-900 text-slate-100
               rounded-2xl p-6 mb-6 overflow-auto">

                <h2 class="font-semibold mb-4">
                    Struktur Data Silsilah
                </h2>

                <pre class="text-xs leading-relaxed">{{ print_r($pohon, true) }}</pre>

            </div>
        @endif



        {{-- Pohon --}}

        @if ($anggota->count())

            <div class="bg-slate-50 border border-slate-200
                   rounded-2xl">

                <div class="family-tree-wrapper">

                    <div class="family-tree">


                        @foreach ($generasi as $nomorGenerasi => $daftarAnggota)
                            {{-- Label generasi --}}

                            <div class="family-tree-generation-label">

                                @if ($nomorGenerasi)
                                    Generasi {{ $nomorGenerasi }}
                                @else
                                    Generasi Belum Ditentukan
                                @endif

                            </div>



                            {{-- Anggota generasi --}}

                            <div class="family-tree-generation">


                                @foreach ($daftarAnggota as $item)
                                    <div class="family-tree-person">


                                        <a href="{{ route('anggota.show', $item->id) }}" class="block">


                                            <div class="family-tree-card">


                                                {{-- Foto --}}

                                                @if ($item->foto)
                                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                                        alt="{{ $item->nama_lengkap }}" class="family-tree-photo">
                                                @else
                                                    <div class="family-tree-photo-placeholder">

                                                        <i data-lucide="user" class="w-7 h-7 text-slate-400">
                                                        </i>

                                                    </div>
                                                @endif



                                                {{-- Nama --}}

                                                <div class="family-tree-name">

                                                    {{ $item->nama_lengkap }}

                                                </div>



                                                {{-- Jenis kelamin --}}

                                                @if ($item->jenis_kelamin)
                                                    <div class="family-tree-gender">

                                                        {{ ucfirst($item->jenis_kelamin) }}

                                                    </div>
                                                @endif


                                            </div>

                                        </a>


                                    </div>
                                @endforeach


                            </div>
                        @endforeach


                    </div>

                </div>

            </div>
        @else
            <div class="bg-white border border-slate-200
                   rounded-2xl p-12 text-center">

                <i data-lucide="git-branch" class="w-10 h-10
                       text-slate-300 mx-auto">
                </i>


                <h3 class="font-semibold mt-4">

                    Belum Ada Data Silsilah

                </h3>


                <p class="text-sm text-slate-500 mt-1">

                    Tambahkan anggota dan hubungan keluarga
                    terlebih dahulu.

                </p>

            </div>


        @endif

    </div>

</x-app-layout>
