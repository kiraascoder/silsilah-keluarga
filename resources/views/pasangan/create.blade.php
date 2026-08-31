<x-app-layout>

<div class="max-w-5xl">

    <div class="mb-7">

        <div class="flex items-center gap-2 text-sm mb-3">

            <a
                href="{{ route('anggota.show', $anggota->id) }}"
                class="text-blue-600 hover:underline">

                Detail Anggota

            </a>

            <span class="text-slate-400">
                ›
            </span>

            <span class="text-slate-500">
                Tambah Pasangan
            </span>

        </div>


        <h1 class="text-3xl font-bold">
            Tambah Pasangan
        </h1>


        <p class="text-slate-500 mt-1">
            Hubungkan anggota dengan pasangan dalam silsilah keluarga.
        </p>

    </div>


    @if(session('error'))

        <div
            class="mb-6 bg-red-50 border border-red-200
                   text-red-700 rounded-xl px-5 py-4">

            {{ session('error') }}

        </div>

    @endif



    <form
        method="POST"
        action="{{ route('pasangan.store') }}"
        class="space-y-6">

        @csrf


        <input
            type="hidden"
            name="anggota_utama_id"
            value="{{ $anggota->id }}">


        {{-- Anggota utama --}}

        <div
            class="bg-white border border-slate-200
                   rounded-2xl p-7">

            <h2 class="text-lg font-bold mb-5">
                Anggota Saat Ini
            </h2>


            <div class="flex items-center gap-4">

                @if($anggota->foto)

                    <img
                        src="{{ asset('storage/'.$anggota->foto) }}"
                        class="w-16 h-16 rounded-full object-cover">

                @else

                    <div
                        class="w-16 h-16 bg-slate-100
                               rounded-full flex items-center justify-center">

                        <i
                            data-lucide="user"
                            class="w-7 h-7 text-slate-400">
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



        {{-- Pasangan --}}

        <div
            class="bg-white border border-slate-200
                   rounded-2xl p-7">

            <h2 class="text-lg font-bold mb-6">
                Informasi Pasangan
            </h2>


            <div class="space-y-6">


                <div>

                    <label class="block font-medium mb-2">
                        Pilih Pasangan
                    </label>

                    <select
                        name="anggota_pasangan_id"
                        class="w-full border border-slate-300
                               rounded-xl px-4 py-3"
                        required>

                        <option value="">
                            Pilih anggota keluarga
                        </option>

                        @foreach($daftarAnggota as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(
                                    old('anggota_pasangan_id')
                                    == $item->id
                                )>

                                {{ $item->nama_lengkap }}

                                @if($item->generasi)
                                    — Generasi {{ $item->generasi }}
                                @endif

                            </option>

                        @endforeach

                    </select>


                    @error('anggota_pasangan_id')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                <div class="grid grid-cols-2 gap-6">


                    <div>

                        <label class="block font-medium mb-2">
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}"
                            class="w-full border border-slate-300
                                   rounded-xl px-4 py-3">

                    </div>



                    <div>

                        <label class="block font-medium mb-2">
                            Tanggal Berakhir
                        </label>

                        <input
                            type="date"
                            name="tanggal_berakhir"
                            value="{{ old('tanggal_berakhir') }}"
                            class="w-full border border-slate-300
                                   rounded-xl px-4 py-3">

                    </div>


                </div>



                <div>

                    <label class="block font-medium mb-2">
                        Catatan
                    </label>

                    <textarea
                        name="catatan"
                        rows="3"
                        class="w-full border border-slate-300
                               rounded-xl px-4 py-3"
                        placeholder="Catatan tambahan jika diperlukan">{{ old('catatan') }}</textarea>

                </div>


            </div>

        </div>



        <div class="flex justify-end gap-3">

            <a
                href="{{ route('anggota.show',$anggota->id) }}"
                class="border border-slate-300
                       rounded-xl px-6 py-3">

                Batal

            </a>


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700
                       text-white rounded-xl
                       px-6 py-3 font-semibold">

                Simpan Pasangan

            </button>

        </div>

    </form>

</div>

</x-app-layout>s
