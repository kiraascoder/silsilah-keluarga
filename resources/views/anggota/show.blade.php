<x-app-layout>

    <div class="max-w-6xl">

        {{-- Header --}}

        <div class="mb-7">

            <a href="{{ route('anggota.index') }}" class="text-sm text-blue-600">

                ← Kembali ke Anggota

            </a>


            <div class="flex justify-between items-start mt-5">

                <div>

                    <h1 class="text-3xl font-bold">
                        Detail Anggota
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Informasi lengkap anggota keluarga.
                    </p>

                </div>


                <a href="{{ route('anggota.edit', $anggota->id) }}"
                    class="inline-flex items-center gap-2
                       border border-slate-300
                       rounded-xl px-5 py-3">

                    <i data-lucide="pencil" class="w-4 h-4"></i>

                    Edit Data

                </a>
                
                <a href="{{ route('relasi.create', $anggota->id) }}"
                    class="border border-slate-300 rounded-xl px-5 py-3">

                    Tambah Hubungan

                </a>

            </div>

        </div>



        {{-- Profil Utama --}}

        <div class="bg-white border border-slate-200
               rounded-2xl p-7 mb-6">


            <div class="flex items-center gap-6">


                @if ($anggota->foto)
                    <img src="{{ asset('storage/' . $anggota->foto) }}" class="w-28 h-28 rounded-full object-cover">
                @else
                    <div
                        class="w-28 h-28 bg-slate-100
                           rounded-full
                           flex items-center justify-center">

                        <i data-lucide="user" class="w-12 h-12 text-slate-400">
                        </i>

                    </div>
                @endif



                <div>


                    <div class="flex items-center gap-3">


                        <h2 class="text-3xl font-bold">

                            {{ $anggota->nama_lengkap }}

                        </h2>


                        @if ($anggota->status_data == 'aktif')
                            <span
                                class="bg-emerald-50
                               text-emerald-600
                               px-3 py-1 rounded-full text-sm">

                                Aktif

                            </span>
                        @endif


                    </div>


                    @if ($anggota->nama_panggilan)
                        <p class="text-slate-500 mt-2">

                            {{ $anggota->nama_panggilan }}

                        </p>
                    @endif


                </div>


            </div>


        </div>




        {{-- Informasi Pribadi --}}


        <div class="bg-white border border-slate-200
               rounded-2xl p-7">


            <h3 class="font-bold text-lg mb-6">

                Informasi Pribadi

            </h3>



            <div class="grid grid-cols-2 gap-6">


                <div>

                    <p class="text-sm text-slate-500">
                        Jenis Kelamin
                    </p>

                    <p class="font-medium">

                        {{ ucfirst($anggota->jenis_kelamin) }}

                    </p>

                </div>



                <div>

                    <p class="text-sm text-slate-500">
                        Generasi
                    </p>

                    <p class="font-medium">

                        {{ $anggota->generasi ? 'Generasi ' . $anggota->generasi : '-' }}

                    </p>

                </div>




                <div>

                    <p class="text-sm text-slate-500">
                        Tempat Lahir
                    </p>

                    <p class="font-medium">

                        {{ $anggota->tempat_lahir ?? '-' }}

                    </p>

                </div>



                <div>

                    <p class="text-sm text-slate-500">
                        Tanggal Lahir
                    </p>

                    <p class="font-medium">

                        {{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d F Y') : '-' }}

                    </p>

                </div>



                <div>

                    <p class="text-sm text-slate-500">
                        Golongan Darah
                    </p>

                    <p class="font-medium">

                        {{ $anggota->golongan_darah ?? '-' }}

                    </p>

                </div>



                <div>

                    <p class="text-sm text-slate-500">
                        Agama
                    </p>

                    <p class="font-medium">

                        {{ $anggota->agama ?? '-' }}

                    </p>

                </div>


                <div>

                    <p class="text-sm text-slate-500">
                        Pekerjaan
                    </p>

                    <p class="font-medium">

                        {{ $anggota->pekerjaan ?? '-' }}

                    </p>

                </div>



                <div>

                    <p class="text-sm text-slate-500">
                        Telepon
                    </p>

                    <p class="font-medium">

                        {{ $anggota->telepon ?? '-' }}

                    </p>

                </div>


            </div>


        </div>


    </div>


</x-app-layout>
