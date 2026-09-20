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

            {{-- Detail hubungan --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-7">

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">
                        Detail Hubungan
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Tentukan hubungan anggota ini dengan anggota keluarga lainnya.
                    </p>
                </div>

                <div class="space-y-6">

                    {{-- Arah hubungan --}}
                    <div>
                        <label for="arah_relasi" class="block text-sm font-medium text-slate-700 mb-2">
                            Hubungkan sebagai
                        </label>

                        <select id="arah_relasi" name="arah_relasi"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3
                       focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">
                                Pilih hubungan
                            </option>

                            <option value="orang_tua" {{ old('arah_relasi') === 'orang_tua' ? 'selected' : '' }}>
                                Orang Tua
                            </option>

                            <option value="anak" {{ old('arah_relasi') === 'anak' ? 'selected' : '' }}>
                                Anak
                            </option>
                        </select>

                        @error('arah_relasi')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Jenis hubungan --}}
                    <div>
                        <label for="jenis_hubungan" class="block text-sm font-medium text-slate-700 mb-2">
                            Jenis Hubungan
                        </label>

                        <select id="jenis_hubungan" name="jenis_hubungan"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3
                       focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">
                                Pilih jenis hubungan
                            </option>
                        </select>

                        @error('jenis_hubungan')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Anggota yang dihubungkan --}}
                    <div>
                        <label for="anggota_id" class="block text-sm font-medium text-slate-700 mb-2">
                            Pilih Anggota Keluarga
                        </label>

                        <select id="anggota_id" name="anggota_id"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3
                       focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">
                                Pilih anggota
                            </option>

                            @foreach ($daftarAnggota as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('anggota_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_lengkap }}
                                    @if ($item->generasi)
                                        — Generasi {{ $item->generasi }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @error('anggota_id')
                            <p class="mt-1 text-sm text-red-600">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const arahRelasi = document.getElementById('arah_relasi');
            const jenisHubungan = document.getElementById('jenis_hubungan');

            const oldJenis = @json(old('jenis_hubungan'));

            function updateJenisHubungan() {

                const arah = arahRelasi.value;

                jenisHubungan.innerHTML = '';

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Pilih jenis hubungan';

                jenisHubungan.appendChild(defaultOption);

                if (arah === 'orang_tua') {

                    const ayah = document.createElement('option');
                    ayah.value = 'ayah';
                    ayah.textContent = 'Ayah';

                    const ibu = document.createElement('option');
                    ibu.value = 'ibu';
                    ibu.textContent = 'Ibu';

                    jenisHubungan.appendChild(ayah);
                    jenisHubungan.appendChild(ibu);

                } else if (arah === 'anak') {

                    const anak = document.createElement('option');
                    anak.value = 'anak';
                    anak.textContent = 'Anak';

                    jenisHubungan.appendChild(anak);
                }

                if (oldJenis) {
                    jenisHubungan.value = oldJenis;
                }
            }

            arahRelasi.addEventListener('change', updateJenisHubungan);

            updateJenisHubungan();
        });
    </script>
</x-app-layout>
