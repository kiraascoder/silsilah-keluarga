<x-app-layout>

    <div class="max-w-6xl">

        {{-- Header --}}
        <div class="mb-7">

            <div class="flex items-center gap-2 text-sm mb-3">

                <a href="{{ route('anggota.index') }}" class="text-blue-600 hover:underline">

                    Anggota Keluarga

                </a>

                <span class="text-slate-400">
                    ›
                </span>

                <span class="text-slate-500">
                    Edit Anggota
                </span>

            </div>


            <h2 class="text-3xl font-bold">
                Edit Anggota
            </h2>


            <p class="text-slate-500 mt-1">
                Perbarui informasi anggota keluarga.
            </p>

        </div>



        {{-- Form --}}

        <form method="POST" action="{{ route('anggota.update', $anggota->id) }}" enctype="multipart/form-data"
            class="space-y-6">

            @csrf
            @method('PUT')



            {{-- Informasi Pribadi --}}

            <div class="bg-white border border-slate-200 rounded-2xl p-7">


                <div class="mb-6">

                    <h3 class="text-lg font-bold">
                        Informasi Pribadi
                    </h3>


                    <p class="text-sm text-slate-500 mt-1">
                        Informasi dasar anggota keluarga.
                    </p>

                </div>




                {{-- Foto --}}

                <div class="flex items-center gap-5 mb-8">


                    @if ($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}" class="w-24 h-24 rounded-full object-cover"
                            alt="{{ $anggota->nama_lengkap }}">
                    @else
                        <div
                            class="w-24 h-24 bg-slate-100 rounded-full
                        flex items-center justify-center">

                            <i data-lucide="user" class="w-10 h-10 text-slate-400">
                            </i>

                        </div>
                    @endif



                    <div>


                        <label for="foto"
                            class="inline-flex items-center gap-2
                        border border-slate-300 rounded-lg
                        px-4 py-2 cursor-pointer hover:bg-slate-50">


                            <i data-lucide="upload" class="w-4 h-4">
                            </i>


                            Ganti Foto


                        </label>


                        <input type="file" id="foto" name="foto" accept="image/*" class="hidden">


                        <p class="text-xs text-slate-400 mt-2">

                            JPG atau PNG maksimal 2 MB.

                        </p>


                        @error('foto')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror


                    </div>


                </div>




                <div class="grid grid-cols-2 gap-6">


                    {{-- Nama Lengkap --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Nama Lengkap

                        </label>


                        <input type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                        @error('nama_lengkap')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror


                    </div>




                    {{-- Nama Panggilan --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Nama Panggilan

                        </label>


                        <input type="text" name="nama_panggilan"
                            value="{{ old('nama_panggilan', $anggota->nama_panggilan) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Tempat Lahir --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Tempat Lahir

                        </label>


                        <input type="text" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Tanggal Lahir --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Tanggal Lahir

                        </label>


                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('Y-m-d') : '') }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Jenis Kelamin --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Jenis Kelamin

                        </label>


                        <select name="jenis_kelamin" class="w-full border border-slate-300 rounded-xl px-4 py-3">


                            <option value="laki-laki" @selected($anggota->jenis_kelamin == 'laki-laki')>

                                Laki-laki

                            </option>


                            <option value="perempuan" @selected($anggota->jenis_kelamin == 'perempuan')>

                                Perempuan

                            </option>


                        </select>


                    </div>





                    {{-- Golongan Darah --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Golongan Darah

                        </label>


                        <select name="golongan_darah" class="w-full border border-slate-300 rounded-xl px-4 py-3">


                            <option value="">
                                Pilih
                            </option>


                            @foreach (['A', 'B', 'AB', 'O'] as $darah)
                                <option value="{{ $darah }}" @selected($anggota->golongan_darah == $darah)>

                                    {{ $darah }}

                                </option>
                            @endforeach


                        </select>


                    </div>





                    {{-- Agama --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Agama

                        </label>


                        <input type="text" name="agama" value="{{ old('agama', $anggota->agama) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Pekerjaan --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Pekerjaan

                        </label>


                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $anggota->pekerjaan) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Telepon --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Nomor Telepon

                        </label>


                        <input type="text" name="telepon" value="{{ old('telepon', $anggota->telepon) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Email --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Email

                        </label>


                        <input type="email" name="email" value="{{ old('email', $anggota->email) }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>




                    {{-- Alamat --}}

                    <div class="col-span-2">


                        <label class="block font-medium mb-2">

                            Alamat

                        </label>


                        <textarea name="alamat" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('alamat', $anggota->alamat) }}</textarea>


                    </div>




                    {{-- Catatan --}}

                    <div class="col-span-2">


                        <label class="block font-medium mb-2">

                            Catatan

                        </label>


                        <textarea name="catatan" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('catatan', $anggota->catatan) }}</textarea>


                    </div>


                </div>


            </div>





            {{-- Hubungan Keluarga --}}


            <div class="bg-white border border-slate-200 rounded-2xl p-7">


                <div class="mb-6">

                    <h3 class="text-lg font-bold">

                        Hubungan Keluarga

                    </h3>


                    <p class="text-sm text-slate-500 mt-1">

                        Informasi posisi anggota dalam silsilah.

                    </p>


                </div>




                <div class="grid grid-cols-2 gap-6">



                    {{-- Generasi --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Generasi

                        </label>


                        <input type="number" name="generasi" value="{{ old('generasi', $anggota->generasi) }}"
                            min="1" class="w-full border border-slate-300 rounded-xl px-4 py-3">


                    </div>





                    {{-- Status Hidup --}}

                    <div>

                        <label class="block font-medium mb-2">

                            Status

                        </label>


                        <select name="status_hidup" class="w-full border border-slate-300 rounded-xl px-4 py-3">


                            <option value="hidup" @selected($anggota->status_hidup == 'hidup')>

                                Hidup

                            </option>


                            <option value="meninggal" @selected($anggota->status_hidup == 'meninggal')>

                                Meninggal

                            </option>


                        </select>


                    </div>


                </div>


            </div>





            {{-- Button --}}


            <div class="flex justify-end gap-3">


                <a href="{{ route('anggota.show', $anggota->id) }}"
                    class="border border-slate-300 rounded-xl px-6 py-3 font-medium hover:bg-slate-50">


                    Batal


                </a>



                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold">


                    Simpan Perubahan


                </button>


            </div>



        </form>


    </div>



</x-app-layout>
