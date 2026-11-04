<x-app-layout title="Edit Sejarah">

    <div class="max-w-4xl mx-auto">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-7">

            <a href="{{ route('sejarah.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Sejarah
            </a>

            <h1 class="text-3xl font-bold text-slate-900 mt-4">
                Edit Sejarah
            </h1>

            <p class="text-slate-500 mt-1">
                Perbarui informasi dan dokumentasi sejarah rumpun keluarga.
            </p>

        </div>


        {{-- =========================================================
            ERROR
        ========================================================== --}}
        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

                <div class="flex items-start gap-3">

                    <i data-lucide="circle-alert" class="w-5 h-5 shrink-0 mt-0.5"></i>

                    <div>

                        <p class="font-semibold mb-2">
                            Terdapat kesalahan:
                        </p>

                        <ul class="list-disc list-inside space-y-1">

                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- =========================================================
            FORM
        ========================================================== --}}
        <form method="POST" action="{{ route('sejarah.update', $sejarah->id) }}" enctype="multipart/form-data"
            class="bg-white border border-slate-200 rounded-2xl p-7 space-y-7">

            @csrf
            @method('PUT')


            {{-- =====================================================
                JUDUL
            ====================================================== --}}
            <div>

                <label for="judul" class="block text-sm font-semibold text-slate-700 mb-2">
                    Judul Sejarah
                </label>

                <input id="judul" name="judul" type="text" value="{{ old('judul', $sejarah->judul) }}" required
                    maxlength="200"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                           outline-none transition"
                    placeholder="Contoh: Awal Berdirinya Rumpun Keluarga">

            </div>


            {{-- =====================================================
                TANGGAL
            ====================================================== --}}
            <div>

                <label for="tanggal" class="block text-sm font-semibold text-slate-700 mb-2">
                    Tanggal Peristiwa
                </label>

                <input id="tanggal" name="tanggal" type="date"
                    value="{{ old('tanggal', $sejarah->tanggal ? \Carbon\Carbon::parse($sejarah->tanggal)->format('Y-m-d') : '') }}"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                           outline-none transition">

                <p class="text-xs text-slate-400 mt-2">
                    Kosongkan jika peristiwa tidak memiliki tanggal pasti.
                </p>

            </div>


            {{-- =====================================================
                FOTO
            ====================================================== --}}
            <div>

                <label for="foto" class="block text-sm font-semibold text-slate-700 mb-2">
                    Foto Dokumentasi
                </label>


                <div
                    class="border-2 border-dashed border-slate-300
                           rounded-2xl p-6
                           hover:border-blue-400
                           transition">

                    {{-- Foto saat ini --}}
                    @if ($sejarah->foto)
                        <div id="foto-lama-container" class="mb-5">

                            <p class="text-sm font-medium text-slate-600 mb-3">
                                Foto Saat Ini
                            </p>

                            <div class="relative inline-block">

                                <img src="{{ asset('storage/' . $sejarah->foto) }}" alt="{{ $sejarah->judul }}"
                                    class="max-h-72 max-w-full rounded-xl
                                           object-contain
                                           border border-slate-200">

                            </div>

                        </div>
                    @endif


                    {{-- Preview foto baru --}}
                    <div id="foto-preview-container" class="hidden mb-5">

                        <p class="text-sm font-medium text-slate-600 mb-3">
                            Preview Foto Baru
                        </p>

                        <img id="foto-preview" src="" alt="Preview foto baru"
                            class="mx-auto max-h-72 max-w-full
                                   rounded-xl object-contain
                                   border border-slate-200">

                    </div>


                    <div class="flex flex-col items-center justify-center text-center">

                        <div id="foto-icon"
                            class="w-14 h-14 rounded-xl bg-blue-50
                                   text-blue-600
                                   flex items-center justify-center mb-4">

                            <i data-lucide="image-plus" class="w-7 h-7"></i>

                        </div>


                        <p class="font-semibold text-slate-700">
                            Ganti Foto
                        </p>

                        <p class="text-sm text-slate-400 mt-1 mb-4">
                            JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                        </p>


                        <label for="foto"
                            class="cursor-pointer inline-flex items-center gap-2
                                   bg-blue-600 hover:bg-blue-700
                                   text-white rounded-xl
                                   px-5 py-2.5
                                   text-sm font-semibold transition">

                            <i data-lucide="upload" class="w-4 h-4"></i>

                            Pilih Foto Baru

                        </label>


                        <input id="foto" name="foto" type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="hidden">


                        <p id="foto-name" class="hidden text-sm text-slate-500 mt-3"></p>


                        <p class="text-xs text-slate-400 mt-3">
                            Kosongkan jika ingin mempertahankan foto saat ini.
                        </p>

                    </div>

                </div>


                @error('foto')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- =====================================================
                DESKRIPSI
            ====================================================== --}}
            <div>

                <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-2">
                    Cerita / Deskripsi
                </label>

                <textarea id="deskripsi" name="deskripsi" rows="9" required
                    class="w-full border border-slate-300 rounded-xl px-4 py-3
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                           outline-none transition resize-y"
                    placeholder="Tuliskan cerita atau informasi sejarah keluarga...">{{ old('deskripsi', $sejarah->deskripsi) }}</textarea>

            </div>


            {{-- =====================================================
                TOMBOL
            ====================================================== --}}
            <div class="flex items-center justify-end gap-3
                       pt-2 border-t border-slate-100">

                <a href="{{ route('sejarah.index') }}"
                    class="inline-flex items-center justify-center
                           border border-slate-300
                           rounded-xl px-6 py-3
                           text-sm font-medium
                           text-slate-700
                           hover:bg-slate-50 transition">
                    Batal
                </a>


                <button type="submit"
                    class="inline-flex items-center justify-center gap-2
                           bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl
                           px-6 py-3
                           text-sm font-semibold
                           transition">

                    <i data-lucide="save" class="w-4 h-4"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>


    {{-- =========================================================
        FOTO PREVIEW
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const fotoInput =
                document.getElementById('foto');

            const previewContainer =
                document.getElementById('foto-preview-container');

            const preview =
                document.getElementById('foto-preview');

            const fotoName =
                document.getElementById('foto-name');

            const fotoIcon =
                document.getElementById('foto-icon');

            const fotoLama =
                document.getElementById('foto-lama-container');


            if (fotoInput) {

                fotoInput.addEventListener('change', function(event) {

                    const file = event.target.files[0];


                    if (!file) {

                        previewContainer.classList.add('hidden');

                        fotoName.classList.add('hidden');

                        fotoIcon.classList.remove('hidden');

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Validasi ukuran
                    |--------------------------------------------------------------------------
                    */

                    if (file.size > 2 * 1024 * 1024) {

                        alert('Ukuran foto maksimal 2 MB.');

                        fotoInput.value = '';

                        previewContainer.classList.add('hidden');

                        fotoName.classList.add('hidden');

                        fotoIcon.classList.remove('hidden');

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Preview foto baru
                    |--------------------------------------------------------------------------
                    */

                    const reader = new FileReader();

                    reader.onload = function(e) {

                        preview.src = e.target.result;

                        previewContainer.classList.remove('hidden');

                        fotoIcon.classList.add('hidden');

                    };

                    reader.readAsDataURL(file);


                    /*
                    |--------------------------------------------------------------------------
                    | Nama file
                    |--------------------------------------------------------------------------
                    */

                    fotoName.textContent =
                        file.name;

                    fotoName.classList.remove('hidden');

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Lucide
            |--------------------------------------------------------------------------
            */

            if (typeof lucide !== 'undefined') {

                lucide.createIcons();

            }

        });
    </script>

</x-app-layout>
