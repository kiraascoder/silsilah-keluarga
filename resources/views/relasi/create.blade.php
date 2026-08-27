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

                Tentukan hubungan anggota dalam struktur silsilah keluarga.

            </p>


        </div>





        <form method="POST" action="{{ route('relasi.store') }}" class="space-y-6">


            @csrf



            {{-- Anggota Saat Ini --}}


            <div class="bg-white border border-slate-200
            rounded-2xl p-7">


                <h2 class="font-bold text-lg mb-5">

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

                            Generasi
                            {{ $anggota->generasi ?? '-' }}

                        </p>

                    </div>


                </div>


            </div>







            {{-- Form Relasi --}}


            <div class="bg-white border border-slate-200
            rounded-2xl p-7">


                <h2 class="font-bold text-lg mb-6">

                    Detail Hubungan

                </h2>



                <div class="grid grid-cols-2 gap-6">



                    {{-- Jenis Hubungan --}}


                    <div>


                        <label class="block font-medium mb-2">

                            Jenis Hubungan

                        </label>



                        <select name="jenis_hubungan"
                            class="w-full border border-slate-300
                        rounded-xl px-4 py-3">


                            <option value="ayah">

                                Ayah

                            </option>


                            <option value="ibu">

                                Ibu

                            </option>


                            <option value="anak">

                                Anak

                            </option>


                        </select>


                    </div>






                    {{-- Pilih Anggota --}}


                    <div>


                        <label class="block font-medium mb-2">

                            Pilih Anggota Keluarga

                        </label>



                        <select name="anggota_id"
                            class="w-full border border-slate-300
                        rounded-xl px-4 py-3">


                            <option value="">

                                Pilih anggota

                            </option>


                            @foreach ($daftarAnggota as $item)
                                <option value="{{ $item->id }}">


                                    {{ $item->nama_lengkap }}


                                </option>
                            @endforeach


                        </select>


                    </div>



                </div>


            </div>





            {{-- Tombol --}}


            <div class="flex justify-end gap-3">


                <a href="{{ route('anggota.show', $anggota->id) }}"
                    class="border border-slate-300
                rounded-xl px-6 py-3">


                    Batal


                </a>




                <button type="submit"
                    class="bg-blue-600 text-white
                rounded-xl px-6 py-3 font-semibold">


                    Simpan Hubungan


                </button>


            </div>


        </form>



    </div>


</x-app-layout>
