<x-app-layout>

    <div class="space-y-7">

        {{-- Header --}}
        <div>

            <h1 class="text-3xl font-bold text-slate-900">
                Selamat datang, {{ auth()->user()->name }}!
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola dan lestarikan silsilah keluarga Anda dengan mudah.
            </p>

        </div>


        {{-- Total Anggota --}}
        <div class="w-80 bg-white
                   border border-slate-200
                   rounded-2xl p-6">

            <div class="flex items-center gap-4">

                <div
                    class="w-16 h-16
                           bg-blue-50 text-blue-600
                           rounded-xl
                           flex items-center justify-center">

                    <i data-lucide="users" class="w-8 h-8"></i>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Total Anggota
                    </p>

                    <p class="text-3xl font-bold">
                        0
                    </p>

                    <a href="{{ route('anggota.index') }}" class="text-sm text-blue-600 hover:underline">
                        Lihat semua anggota →
                    </a>

                </div>

            </div>

        </div>


        {{-- Pohon --}}
        <div class="bg-white
                   border border-slate-200
                   rounded-2xl p-7">

            <div class="flex items-start justify-between mb-7">

                <div>

                    <h2 class="text-xl font-bold">
                        Pohon Silsilah Keluarga
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Lihat struktur pohon silsilah keluarga Anda.
                    </p>

                </div>

                <a href="{{ route('pohon.index') }}"
                    class="border border-slate-300
                           rounded-xl px-4 py-2
                           text-sm font-medium
                           hover:bg-slate-50">
                    Lihat Pohon Lengkap
                </a>

            </div>


            <div
                class="h-72
                       bg-slate-50
                       border border-dashed border-slate-300
                       rounded-xl
                       flex flex-col
                       items-center justify-center
                       text-slate-400">

                <i data-lucide="git-fork" class="w-14 h-14 mb-3"></i>

                <p>
                    Pohon silsilah akan tampil di sini
                </p>

            </div>

        </div>

    </div>

</x-app-layout>
