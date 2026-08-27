<x-app-layout>

    <div>

        <div class="flex items-start justify-between mb-7">

            <div>
                <h1 class="text-3xl font-bold">
                    Anggota Keluarga
                </h1>

                <p class="text-slate-500 mt-1">
                    Kelola dan lihat seluruh anggota keluarga dalam silsilah.
                </p>
            </div>

            <a href="{{ route('anggota.create') }}"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-xl font-semibold hover:bg-blue-700">
                <i data-lucide="plus" class="w-5 h-5"></i>

                Tambah Anggota
            </a>

        </div>


        {{-- Filter --}}
        <form method="GET" action="{{ route('anggota.index') }}"
            class="bg-white border border-slate-200 rounded-2xl p-5 mb-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div class="md:col-span-2">

                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari anggota..."
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>


                <select name="generasi" class="border border-slate-300 rounded-xl px-4 py-3">

                    <option value="">
                        Semua Generasi
                    </option>

                    @foreach ($daftarGenerasi as $generasi)
                        <option value="{{ $generasi }}" @selected(request('generasi') == $generasi)>
                            Generasi {{ $generasi }}
                        </option>
                    @endforeach

                </select>


                <div class="flex gap-2">

                    <button class="flex-1 bg-slate-900 text-white rounded-xl px-4 py-3">
                        Filter
                    </button>

                    <a href="{{ route('anggota.index') }}" class="border border-slate-300 rounded-xl px-4 py-3">
                        Reset
                    </a>

                </div>

            </div>

        </form>


        {{-- Table --}}
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr class="text-left text-sm text-slate-500">

                            <th class="px-6 py-4">
                                Anggota
                            </th>

                            <th class="px-6 py-4">
                                Jenis Kelamin
                            </th>

                            <th class="px-6 py-4">
                                Tanggal Lahir
                            </th>

                            <th class="px-6 py-4">
                                Generasi
                            </th>

                            <th class="px-6 py-4">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($anggota as $item)
                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                alt="{{ $item->nama_lengkap }}"
                                                class="w-11 h-11 rounded-full object-cover">
                                        @else
                                            <div
                                                class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center">
                                                <i data-lucide="user" class="w-5 h-5 text-slate-400"></i>
                                            </div>
                                        @endif


                                        <div>

                                            <a href="{{ route('anggota.show', $item->id) }}"
                                                class="font-semibold text-slate-900 hover:text-blue-600">
                                                {{ $item->nama_lengkap }}
                                            </a>

                                            @if ($item->nama_panggilan)
                                                <p class="text-sm text-slate-400">
                                                    {{ $item->nama_panggilan }}
                                                </p>
                                            @endif

                                        </div>

                                    </div>

                                </td>


                                <td class="px-6 py-4 text-sm">
                                    {{ ucfirst($item->jenis_kelamin) }}
                                </td>


                                <td class="px-6 py-4 text-sm">

                                    {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '-' }}

                                </td>


                                <td class="px-6 py-4">

                                    @if ($item->generasi)
                                        <span
                                            class="bg-indigo-50 text-indigo-600 text-xs font-medium px-3 py-1 rounded-full">
                                            Generasi {{ $item->generasi }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">
                                            -
                                        </span>
                                    @endif

                                </td>


                                <td class="px-6 py-4">

                                    @if ($item->status_data === 'aktif')
                                        <span
                                            class="bg-emerald-50 text-emerald-600 text-xs font-medium px-3 py-1 rounded-full">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="bg-slate-100 text-slate-500 text-xs font-medium px-3 py-1 rounded-full">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>


                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a href="{{ route('anggota.show', $item->id) }}"
                                            class="font-semibold hover:text-blue-600">

                                            {{ $item->nama_lengkap }}

                                        </a>


                                        <a href="{{ route('anggota.edit', $item->id) }}"
                                            class="border border-slate-300 rounded-lg p-2 hover:bg-slate-50"
                                            title="Edit">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-16 text-center">

                                    <div
                                        class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto">
                                        <i data-lucide="users" class="w-6 h-6 text-slate-400"></i>
                                    </div>

                                    <h3 class="font-semibold mt-4">
                                        Belum Ada Anggota
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Tambahkan anggota pertama untuk mulai membangun silsilah.
                                    </p>

                                    <a href="{{ route('anggota.create') }}"
                                        class="inline-flex items-center gap-2 mt-5 bg-blue-600 text-white rounded-xl px-5 py-3">
                                        <i data-lucide="plus" class="w-4 h-4"></i>

                                        Tambah Anggota
                                    </a>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($anggota->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $anggota->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>
