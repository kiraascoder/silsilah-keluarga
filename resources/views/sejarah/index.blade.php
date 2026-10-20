<x-app-layout title="Sejarah Keluarga">

    <div class="max-w-6xl mx-auto">
        <div class="mb-7 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Sejarah Keluarga</h1>
                <p class="text-slate-500 mt-1">Catat peristiwa dan cerita penting dalam {{ $keluargaAktif->nama_keluarga }}.</p>
            </div>
            @if (in_array(session('keluarga_level_akses'), ['pemilik', 'editor'], true))
                <a href="{{ route('sejarah.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-3 font-semibold">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Sejarah
                </a>
            @endif
        </div>

        @forelse ($sejarah as $item)
            <article class="bg-white border border-slate-200 rounded-2xl p-6 mb-4">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-xl font-bold text-slate-900">{{ $item->judul }}</h2>
                            @if ($item->tanggal)
                                <span class="inline-flex rounded-full bg-slate-100 text-slate-600 px-2.5 py-1 text-xs font-semibold">{{ $item->tanggal->format('d F Y') }}</span>
                            @endif
                        </div>
                        <div class="mt-4 text-sm leading-7 text-slate-700 whitespace-pre-line">{{ $item->deskripsi }}</div>
                    </div>
                    @if (in_array(session('keluarga_level_akses'), ['pemilik', 'editor'], true))
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('sejarah.edit', $item->id) }}" class="inline-flex items-center gap-2 border border-slate-300 rounded-xl px-4 py-2 text-sm font-semibold hover:bg-slate-50">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('sejarah.destroy', $item->id) }}" onsubmit="return confirm('Hapus catatan sejarah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 border border-red-200 text-red-600 rounded-xl px-4 py-2 text-sm font-semibold hover:bg-red-50">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">
                <i data-lucide="book-open" class="w-12 h-12 text-slate-300 mx-auto"></i>
                <h2 class="font-bold text-lg mt-4">Belum Ada Sejarah</h2>
                <p class="text-slate-500 mt-2">Belum ada catatan sejarah untuk rumpun keluarga ini.</p>
            </div>
        @endforelse

        <div class="mt-6">{{ $sejarah->links() }}</div>
    </div>

    <script>
        if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    </script>

</x-app-layout>
