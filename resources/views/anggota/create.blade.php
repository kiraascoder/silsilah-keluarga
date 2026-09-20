<x-app-layout>

    <div class="max-w-5xl">

        {{-- Header --}}

        <div class="mb-7">

            <a href="{{ route('anggota.index') }}"
                class="inline-flex items-center gap-2
                       text-sm text-slate-500
                       hover:text-blue-600">

                <i data-lucide="arrow-left" class="w-4 h-4"></i>

                Kembali

            </a>


            <h1 class="text-3xl font-bold mt-4">
                Tambah Anggota
            </h1>


            <p class="text-slate-500 mt-1">
                Tambahkan informasi anggota keluarga ke dalam silsilah.
            </p>

        </div>



        {{-- Error Umum --}}

        @if ($errors->any())

            <div
                class="mb-6
                       bg-red-50
                       border border-red-200
                       text-red-700
                       rounded-xl
                       p-4">

                <p class="font-semibold mb-2">
                    Terdapat kesalahan:
                </p>

                <ul class="list-disc list-inside text-sm">

                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

            </div>

        @endif



        {{-- Form --}}

        <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf



            {{-- Informasi Anggota --}}

            <div
                class="bg-white
                       border border-slate-200
                       rounded-2xl
                       p-7">

                <div class="mb-7">

                    <h2 class="text-lg font-bold">
                        Informasi Anggota
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Masukkan informasi dasar anggota keluarga.
                    </p>

                </div>



                <div
                    class="grid
                           grid-cols-1
                           md:grid-cols-2
                           gap-6">


                    {{-- Foto --}}

                    <div class="md:col-span-2">

                        <label for="foto"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Foto
                        </label>


                        <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3
                                   text-sm">


                        <p class="text-xs text-slate-400 mt-2">
                            JPG atau PNG, maksimal 2 MB.
                        </p>


                        @error('foto')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Nama Lengkap --}}

                    <div>

                        <label for="nama_lengkap"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">

                            Nama Lengkap

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            placeholder="Masukkan nama lengkap" required
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">


                        @error('nama_lengkap')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Nama Panggilan --}}

                    <div>

                        <label for="nama_panggilan"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Nama Panggilan
                        </label>


                        <input type="text" id="nama_panggilan" name="nama_panggilan"
                            value="{{ old('nama_panggilan') }}" placeholder="Nama panggilan"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">


                        @error('nama_panggilan')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Jenis Kelamin --}}

                    <div>

                        <label for="jenis_kelamin"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">

                            Jenis Kelamin

                            <span class="text-red-500">
                                *
                            </span>

                        </label>


                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">

                            <option value="">
                                Pilih jenis kelamin
                            </option>


                            <option value="laki-laki" @selected(old('jenis_kelamin') === 'laki-laki')>
                                Laki-laki
                            </option>


                            <option value="perempuan" @selected(old('jenis_kelamin') === 'perempuan')>
                                Perempuan
                            </option>

                        </select>


                        @error('jenis_kelamin')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Golongan Darah --}}

                    <div>

                        <label for="golongan_darah"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Golongan Darah
                        </label>


                        <select id="golongan_darah" name="golongan_darah"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">

                            <option value="">
                                Tidak diketahui
                            </option>


                            @foreach (['A', 'B', 'AB', 'O'] as $darah)
                                <option value="{{ $darah }}" @selected(old('golongan_darah') === $darah)>
                                    {{ $darah }}
                                </option>
                            @endforeach

                        </select>


                        @error('golongan_darah')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Tempat Lahir --}}

                    <div>

                        <label for="tempat_lahir"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Tempat Lahir
                        </label>


                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            placeholder="Contoh: Makassar"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">


                        @error('tempat_lahir')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Tanggal Lahir --}}

                    <div>

                        <label for="tanggal_lahir"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Tanggal Lahir
                        </label>


                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">


                        @error('tanggal_lahir')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>



            {{-- Informasi Silsilah --}}

            <div
                class="bg-white
                       border border-slate-200
                       rounded-2xl
                       p-7">

                <div class="mb-6">

                    <h2 class="text-lg font-bold">
                        Informasi Silsilah
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Tentukan posisi dasar anggota dalam silsilah.
                    </p>

                </div>


                <div
                    class="grid
                           grid-cols-1
                           md:grid-cols-2
                           gap-6">


                    {{-- Generasi --}}

                    <div>

                        <label for="generasi"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Generasi
                        </label>


                        <input type="number" id="generasi" name="generasi" min="1"
                            value="{{ old('generasi') }}" placeholder="Contoh: 1"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">


                        <p class="text-xs text-slate-400 mt-2">
                            Bisa dikosongkan jika belum ditentukan.
                        </p>


                        @error('generasi')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>



                    {{-- Status --}}

                    <div>

                        <label for="status"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Status
                        </label>


                        <select id="status" name="status"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">

                            <option value="hidup" @selected(old('status', 'hidup') === 'hidup')>
                                Hidup
                            </option>


                            <option value="meninggal" @selected(old('status') === 'meninggal')>
                                Meninggal
                            </option>

                        </select>


                        @error('status')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>



            {{-- Tombol --}}

            <div class="flex justify-end gap-3">

                <a href="{{ route('anggota.index') }}"
                    class="border
                           border-slate-300
                           rounded-xl
                           px-6
                           py-3
                           font-medium
                           hover:bg-slate-50">
                    Batal
                </a>


                <button type="submit"
                    class="bg-blue-600
                           hover:bg-blue-700
                           text-white
                           rounded-xl
                           px-6
                           py-3
                           font-semibold">
                    Simpan Anggota
                </button>

            </div>

        </form>

    </div>


    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>

</x-app-layout>
