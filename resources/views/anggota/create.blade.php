<x-app-layout>

    <div class="max-w-5xl">

        <div class="mb-7">

            <a href="{{ route('anggota.index') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600">
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


        <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf


            <div class="bg-white border border-slate-200 rounded-2xl p-7">

                <h2 class="text-lg font-bold">
                    Informasi Anggota
                </h2>

                <p class="text-sm text-slate-500 mt-1 mb-7">
                    Masukkan informasi dasar anggota keluarga.
                </p>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium mb-2">
                            Foto
                        </label>

                        <input type="file" name="foto" accept="image/*"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3" required>

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nama Panggilan
                        </label>

                        <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}"
                            placeholder="Nama panggilan" class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Jenis Kelamin
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="jenis_kelamin" class="w-full border border-slate-300 rounded-xl px-4 py-3"
                            required>

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

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Generasi
                        </label>

                        <input type="number" name="generasi" min="1" value="{{ old('generasi') }}"
                            placeholder="Contoh: 3" class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Tempat Lahir
                        </label>

                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                            placeholder="Contoh: Makassar" class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Tanggal Lahir
                        </label>

                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Status Hidup
                        </label>

                        <select name="status_hidup" class="w-full border border-slate-300 rounded-xl px-4 py-3">

                            <option value="hidup" @selected(old('status_hidup', 'hidup') === 'hidup')>
                                Hidup
                            </option>

                            <option value="meninggal" @selected(old('status_hidup') === 'meninggal')>
                                Meninggal
                            </option>

                        </select>

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Golongan Darah
                        </label>

                        <select name="golongan_darah" class="w-full border border-slate-300 rounded-xl px-4 py-3">

                            <option value="">Tidak diketahui</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>

                        </select>

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Agama
                        </label>

                        <input type="text" name="agama" value="{{ old('agama') }}" placeholder="Masukkan agama"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Pekerjaan
                        </label>

                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                            placeholder="Masukkan pekerjaan"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Telepon
                        </label>

                        <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="08xxxxxxxxxx"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    </div>


                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium mb-2">
                            Alamat
                        </label>

                        <textarea name="alamat" rows="3" placeholder="Masukkan alamat"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('alamat') }}</textarea>

                    </div>


                    <div class="md:col-span-2">

                        <label class="block text-sm font-medium mb-2">
                            Catatan
                        </label>

                        <textarea name="catatan" rows="3" placeholder="Catatan tambahan jika diperlukan"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('catatan') }}</textarea>

                    </div>

                </div>

            </div>


            <div class="flex justify-end gap-3">

                <a href="{{ route('anggota.index') }}"
                    class="border border-slate-300 rounded-xl px-6 py-3 font-medium hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold">
                    Simpan Anggota
                </button>

            </div>

        </form>

    </div>

</x-app-layout>
