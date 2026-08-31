<x-app-layout>

    <div class="max-w-5xl">

        {{-- Header --}}
        <div class="mb-7">

            <div class="flex items-center gap-2 text-sm mb-3">

                <a href="{{ route('anggota.show', $anggota->id) }}" class="text-blue-600 hover:underline">

                    Detail Anggota

                </a>

                <span class="text-slate-400">
                    ›
                </span>

                <span class="text-slate-500">
                    Tambah Hubungan
                </span>

            </div>


            <h1 class="text-3xl font-bold">
                Tambah Hubungan Keluarga
            </h1>


            <p class="text-slate-500 mt-1">
                Hubungkan anggota dengan orang tua atau anaknya.
            </p>

        </div>



        {{-- Pesan error --}}

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200
                   text-red-700 rounded-xl px-5 py-4">

                {{ session('error') }}

            </div>
        @endif



        <form method="POST" action="{{ route('relasi.store') }}" class="space-y-6">

            @csrf


            <input type="hidden" name="anggota_utama_id" value="{{ $anggota->id }}">



            {{-- Anggota utama --}}

            <div class="bg-white border border-slate-200
                   rounded-2xl p-7">

                <h2 class="text-lg font-bold mb-5">
                    Anggota Saat Ini
                </h2>


                <div class="flex items-center gap-4">

                    @if ($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}" class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div
                            class="w-16 h-16 bg-slate-100
                               rounded-full flex items-center justify-center">

                            <i data-lucide="user" class="w-7 h-7 text-slate-400">
                            </i>

                        </div>
                    @endif


                    <div>

                        <p class="font-semibold text-lg">
                            {{ $anggota->nama_lengkap }}
                        </p>

                        <p class="text-sm text-slate-500">
                            Generasi {{ $anggota->generasi ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>



            {{-- Detail hubungan --}}

            <div class="bg-white border border-slate-200
                   rounded-2xl p-7">

                <h2 class="text-lg font-bold mb-6">
                    Detail Hubungan
                </h2>


                <div class="grid grid-cols-2 gap-6">


                    {{-- Arah hubungan --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Hubungan

                        </label>


                        <select name="arah_relasi"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3"
                            required>


                            <option value="">
                                Pilih hubungan
                            </option>


                            <option value="orang_tua" @selected(old('arah_relasi') === 'orang_tua')>

                                Dia adalah orang tua

                            </option>


                            <option value="anak" @selected(old('arah_relasi') === 'anak')>

                                Dia adalah anak

                            </option>


                        </select>

                        @error('arah_relasi')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Jenis hubungan --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Jenis Hubungan

                        </label>


                        <select name="jenis_hubungan"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3"
                            required>


                            <option value="">
                                Pilih jenis hubungan
                            </option>


                            <option value="ayah" @selected(old('jenis_hubungan') === 'ayah')>

                                Ayah

                            </option>


                            <option value="ibu" @selected(old('jenis_hubungan') === 'ibu')>

                                Ibu

                            </option>


                            <option value="anak" @selected(old('jenis_hubungan') === 'anak')>

                                Anak

                            </option>


                        </select>

                        @error('jenis_hubungan')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Pilih anggota --}}

                    <div class="col-span-2">

                        <label class="block font-medium mb-2">

                            Pilih Anggota Keluarga

                        </label>


                        <select name="anggota_id"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3"
                            required>


                            <option value="">
                                Pilih anggota
                            </option>


                            @foreach ($daftarAnggota as $item)
                                <option value="{{ $item->id }}" @selected(old('anggota_id') == $item->id)>

                                    {{ $item->nama_lengkap }}

                                    @if ($item->generasi)
                                        — Generasi {{ $item->generasi }}
                                    @endif

                                </option>
                            @endforeach


                        </select>


                        @error('anggota_id')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                </div>

            </div>



            {{-- Tombol --}}

            <div class="flex justify-end gap-3">

                <a href="{{ route('anggota.show', $anggota->id) }}"
                    class="border border-slate-300
                       rounded-xl px-6 py-3
                       font-medium hover:bg-slate-50">

                    Batal

                </a>


                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700
                       text-white rounded-xl
                       px-6 py-3 font-semibold">

                    Simpan Hubungan

                </button>

            </div>

        </form>

    </div>

</x-app-layout>
