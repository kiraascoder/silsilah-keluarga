<x-app-layout>

    <div class="max-w-5xl">

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


            <h1 class="text-3xl font-bold">
                Edit Anggota
            </h1>


            <p class="text-slate-500 mt-1">
                Perbarui informasi anggota keluarga.
            </p>

        </div>



        {{-- Error --}}

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



        {{-- Success --}}

        @if (session('success'))
            <div
                class="mb-6
                       bg-green-50
                       border border-green-200
                       text-green-700
                       rounded-xl
                       p-4">
                {{ session('success') }}
            </div>
        @endif



        {{-- Form --}}

        <form method="POST" action="{{ route('anggota.update', $anggota->id) }}" enctype="multipart/form-data"
            class="space-y-6">

            @csrf

            @method('PUT')



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
                        Perbarui informasi dasar anggota keluarga.
                    </p>

                </div>



                {{-- Foto --}}

                <div
                    class="flex
                           flex-col
                           sm:flex-row
                           sm:items-center
                           gap-5
                           mb-8">

                    @if ($anggota->foto)
                        <img src="{{ asset('storage/' . $anggota->foto) }}"
                            class="w-24 h-24
                                   rounded-full
                                   object-cover
                                   border border-slate-200"
                            alt="{{ $anggota->nama_lengkap }}">
                    @else
                        <div
                            class="w-24 h-24
                                   bg-slate-100
                                   rounded-full
                                   flex items-center
                                   justify-center">

                            <i data-lucide="user"
                                class="w-10 h-10
                                       text-slate-400"></i>

                        </div>
                    @endif


                    <div>

                        <label for="foto"
                            class="inline-flex
                                   items-center
                                   gap-2
                                   border
                                   border-slate-300
                                   rounded-lg
                                   px-4
                                   py-2
                                   cursor-pointer
                                   hover:bg-slate-50">

                            <i data-lucide="upload" class="w-4 h-4"></i>

                            Ganti Foto

                        </label>


                        <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png" class="hidden">


                        <p class="text-xs text-slate-400 mt-2">
                            JPG atau PNG, maksimal 2 MB.
                        </p>


                        @error('foto')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>



                {{-- Form Grid --}}

                <div
                    class="grid
                           grid-cols-1
                           md:grid-cols-2
                           gap-6">


                    {{-- Nama Lengkap --}}

                    <div>

                        <label for="nama_lengkap"
                            class="block
                                   text-sm
                                   font-medium
                                   mb-2">
                            Nama Lengkap
                        </label>


                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}"
                            required
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
                            value="{{ old('nama_panggilan', $anggota->nama_panggilan) }}"
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
                        </label>


                        <select id="jenis_kelamin" name="jenis_kelamin" required
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">

                            <option value="laki-laki" @selected(old('jenis_kelamin', $anggota->jenis_kelamin) === 'laki-laki')>
                                Laki-laki
                            </option>


                            <option value="perempuan" @selected(old('jenis_kelamin', $anggota->jenis_kelamin) === 'perempuan')>
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
                                <option value="{{ $darah }}" @selected(old('golongan_darah', $anggota->golongan_darah) === $darah)>
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


                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}"
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
                            value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('Y-m-d') : '') }}"
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
                        Informasi posisi anggota dalam silsilah.
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
                            value="{{ old('generasi', $anggota->generasi) }}"
                            class="w-full
                                   border
                                   border-slate-300
                                   rounded-xl
                                   px-4
                                   py-3">


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

                            <option value="hidup" @selected(old('status', $anggota->status) === 'hidup')>
                                Hidup
                            </option>


                            <option value="meninggal" @selected(old('status', $anggota->status) === 'meninggal')>
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

                <a href="{{ route('anggota.show', $anggota->id) }}"
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
                    Simpan Perubahan
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
