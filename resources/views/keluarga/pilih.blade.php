<x-app-layout title="Pilih Rumpun Keluarga">

    <div class="max-w-6xl mx-auto">
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Pilih Rumpun Keluarga</h1>
                <p class="text-slate-500 mt-2">Pilih keluarga yang ingin Anda kelola atau buat rumpun keluarga baru.</p>
            </div>
            <a href="{{ route('keluarga.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-3 font-semibold">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Buat Rumpun Keluarga
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($keluarga as $item)
                @php
                    $keanggotaan = $item->pengguna->first()?->pivot;
                    $isOwner = $keanggotaan?->level_akses === 'pemilik';
                    $isActive = (int) session('keluarga_id') === (int) $item->id;
                @endphp

                <div class="bg-white border {{ $isActive ? 'border-blue-300 ring-2 ring-blue-100' : 'border-slate-200' }} rounded-2xl p-6 flex flex-col">
                    <div class="flex items-start justify-between gap-3">
                        @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-14 h-14 object-cover rounded-xl" alt="{{ $item->nama_keluarga }}">
                        @else
                            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                                <i data-lucide="users"></i>
                            </div>
                        @endif
                        @if ($isActive)
                            <span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2.5 py-1 text-xs font-semibold">Aktif</span>
                        @endif
                    </div>

                    <h2 class="font-bold text-lg mt-5">{{ $item->nama_keluarga }}</h2>
                    <p class="text-slate-500 mt-2">{{ $item->asal_daerah ?? 'Asal daerah belum diisi' }}</p>
                    <p class="text-sm text-slate-400 mt-1">{{ $item->anggota_count }} anggota keluarga</p>
                    @if ($item->deskripsi)
                        <p class="text-sm text-slate-600 mt-4 leading-6 line-clamp-3">{{ $item->deskripsi }}</p>
                    @endif

                    <div class="mt-auto pt-6 flex items-center justify-between gap-3">
                        <form method="POST" action="{{ route('keluarga.aktif', $item) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-700">
                                Masuk ke keluarga
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </form>

                        @if ($isOwner)
                            <form method="POST" action="{{ route('keluarga.destroy', $item) }}" onsubmit="return confirm('PERINGATAN: Seluruh data anggota, relasi, dokumen, undangan, dan sejarah keluarga ini akan dihapus permanen. Lanjutkan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 text-red-600 hover:bg-red-50 rounded-lg px-3 py-2 text-sm font-semibold" title="Hapus rumpun keluarga">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 xl:col-span-3 bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">
                    <i data-lucide="users" class="w-12 h-12 text-slate-300 mx-auto"></i>
                    <h3 class="font-bold text-lg mt-4">Belum Ada Rumpun Keluarga</h3>
                    <p class="text-slate-500 mt-2">Buat rumpun keluarga pertama Anda untuk mulai membangun silsilah.</p>
                </div>
            @endforelse
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-6 mt-10">
            <h3 class="font-bold text-lg mb-2">Bergabung dengan Keluarga</h3>
            <p class="text-slate-500 mb-5">Masukkan kode undangan yang diberikan oleh anggota keluarga.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" placeholder="Masukkan kode undangan" class="flex-1 border border-slate-300 rounded-xl px-4 py-3">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold">Gabung</button>
            </div>
        </div>
    </div>

    <script>
        if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    </script>

</x-app-layout>
