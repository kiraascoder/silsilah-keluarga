<x-app-layout title="Sejarah Keluarga">

    <div class="max-w-6xl mx-auto">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-7 flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-slate-900">
                    Sejarah Keluarga
                </h1>

                <p class="text-slate-500 mt-1">
                    Catat peristiwa dan cerita penting dalam
                    {{ $keluargaAktif->nama_keluarga }}.
                </p>

            </div>


            @if (in_array(session('keluarga_level_akses'), ['pemilik', 'editor'], true))
                <a href="{{ route('sejarah.create') }}"
                    class="inline-flex items-center justify-center gap-2
                           bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl
                           px-5 py-3
                           font-semibold
                           transition">

                    <i data-lucide="plus" class="w-4 h-4"></i>

                    Tambah Sejarah

                </a>
            @endif

        </div>


        {{-- =========================================================
            DAFTAR SEJARAH
        ========================================================== --}}
        <div class="space-y-5">

            @forelse ($sejarah as $item)
                <article
                    class="bg-white
                           border border-slate-200
                           rounded-2xl
                           overflow-hidden
                           transition
                           hover:border-slate-300
                           hover:shadow-sm">

                    <div class="flex flex-col md:flex-row">


                        {{-- =================================================
                            FOTO
                        ================================================== --}}
                        <div class="md:w-72 lg:w-80 shrink-0">

                            @if ($item->foto)
                                <div class="h-64 md:h-full min-h-64">

                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}"
                                        class="w-full h-full object-cover">

                                </div>
                            @else
                                <div
                                    class="h-64 md:h-full min-h-64
                                           bg-slate-50
                                           flex flex-col
                                           items-center
                                           justify-center
                                           text-slate-300">

                                    <i data-lucide="image" class="w-12 h-12 mb-3"></i>

                                    <p class="text-sm">
                                        Tidak ada foto
                                    </p>

                                </div>
                            @endif

                        </div>


                        {{-- =================================================
                            KONTEN
                        ================================================== --}}
                        <div class="flex-1 p-6 lg:p-7">

                            <div
                                class="flex flex-col
                                       lg:flex-row
                                       lg:items-start
                                       lg:justify-between
                                       gap-4">

                                {{-- Informasi sejarah --}}
                                <div class="min-w-0 flex-1">

                                    {{-- Tanggal --}}
                                    @if ($item->tanggal)
                                        <div
                                            class="inline-flex items-center gap-2
                                                   rounded-full
                                                   bg-blue-50
                                                   text-blue-600
                                                   px-3 py-1.5
                                                   text-xs
                                                   font-semibold
                                                   mb-3">

                                            <i data-lucide="calendar" class="w-3.5 h-3.5"></i>

                                            {{ $item->tanggal->format('d F Y') }}

                                        </div>
                                    @endif


                                    {{-- Judul --}}
                                    <h2
                                        class="text-xl
                                               lg:text-2xl
                                               font-bold
                                               text-slate-900">
                                        {{ $item->judul }}
                                    </h2>


                                    {{-- Deskripsi --}}
                                    <div
                                        class="mt-4
                                               text-sm
                                               leading-7
                                               text-slate-600
                                               whitespace-pre-line">
                                        {{ $item->deskripsi }}
                                    </div>

                                </div>


                                {{-- =================================================
                                    ACTION
                                ================================================== --}}
                                @if (in_array(session('keluarga_level_akses'), ['pemilik', 'editor'], true))
                                    <div
                                        class="flex items-center gap-2
                                               shrink-0">

                                        {{-- Edit --}}
                                        <a href="{{ route('sejarah.edit', $item->id) }}"
                                            class="inline-flex items-center gap-2
                                                   border border-slate-300
                                                   rounded-xl
                                                   px-4 py-2
                                                   text-sm
                                                   font-semibold
                                                   text-slate-700
                                                   hover:bg-slate-50
                                                   transition">

                                            <i data-lucide="pencil" class="w-4 h-4"></i>

                                            Edit

                                        </a>


                                        {{-- Hapus --}}
                                        <form method="POST" action="{{ route('sejarah.destroy', $item->id) }}"
                                            onsubmit="return confirm('Hapus catatan sejarah ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center gap-2
                                                       border border-red-200
                                                       text-red-600
                                                       rounded-xl
                                                       px-4 py-2
                                                       text-sm
                                                       font-semibold
                                                       hover:bg-red-50
                                                       transition">

                                                <i data-lucide="trash-2" class="w-4 h-4"></i>

                                                Hapus

                                            </button>

                                        </form>

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                </article>

            @empty

                {{-- =========================================================
                    EMPTY STATE
                ========================================================== --}}
                <div
                    class="bg-white
                           border border-dashed
                           border-slate-300
                           rounded-2xl
                           p-12
                           text-center">

                    <div
                        class="w-16 h-16
                               rounded-2xl
                               bg-slate-50
                               flex items-center justify-center
                               mx-auto">

                        <i data-lucide="book-open" class="w-8 h-8 text-slate-300"></i>

                    </div>


                    <h2
                        class="font-bold
                               text-lg
                               text-slate-700
                               mt-5">
                        Belum Ada Sejarah
                    </h2>


                    <p
                        class="text-slate-500
                               text-sm
                               mt-2
                               max-w-md
                               mx-auto">
                        Belum ada catatan sejarah untuk rumpun keluarga ini.
                        Tambahkan peristiwa penting untuk mulai mendokumentasikan
                        perjalanan keluarga.
                    </p>


                    @if (in_array(session('keluarga_level_akses'), ['pemilik', 'editor'], true))
                        <a href="{{ route('sejarah.create') }}"
                            class="inline-flex items-center gap-2
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   rounded-xl
                                   px-5 py-3
                                   mt-5
                                   text-sm
                                   font-semibold
                                   transition">

                            <i data-lucide="plus" class="w-4 h-4"></i>

                            Tambah Sejarah

                        </a>
                    @endif

                </div>
            @endforelse

        </div>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}
        @if ($sejarah->hasPages())
            <div class="mt-6">

                {{ $sejarah->links() }}

            </div>
        @endif

    </div>


    {{-- =========================================================
        LUCIDE
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        });
    </script>

</x-app-layout>
