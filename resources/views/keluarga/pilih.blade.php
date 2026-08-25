@extends('layouts.member')

@section('title', 'Pilih Rumpun Keluarga')

@section('content')

    <div class="max-w-6xl mx-auto">

        <div class="mb-8">

            <h2 class="text-3xl font-bold">
                Pilih Rumpun Keluarga
            </h2>

            <p class="text-slate-500 mt-2">
                Pilih keluarga yang ingin Anda kelola atau buat rumpun keluarga baru.
            </p>

        </div>

        <div class="grid grid-cols-3 gap-6">

            @forelse ($keluarga as $item)
                <div class="bg-white border border-slate-200 rounded-2xl p-6">

                    @if ($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" class="w-14 h-14 object-cover rounded-xl mb-5"
                            alt="{{ $item->nama_keluarga }}">
                    @else
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-5">

                            <i data-lucide="users"></i>

                        </div>
                    @endif

                    <h3 class="font-bold text-lg">
                        {{ $item->nama_keluarga }}
                    </h3>

                    <p class="text-slate-500 mt-2">
                        {{ $item->asal_daerah ?? 'Asal daerah belum diisi' }}
                    </p>

                    <p class="text-sm text-slate-400 mt-1">
                        {{ $item->anggota()->count() }} anggota keluarga
                    </p>

                    <form method="POST" action="{{ route('keluarga.aktif', $item) }}" class="mt-5">

                        @csrf

                        <button type="submit" class="text-blue-600 font-medium">

                            Masuk ke keluarga →

                        </button>

                    </form>

                </div>

            @empty

                <div class="col-span-2 bg-white border rounded-2xl p-10 text-center">

                    <i data-lucide="users" class="w-12 h-12 text-slate-300 mx-auto">
                    </i>

                    <h3 class="font-bold text-lg mt-4">
                        Belum Ada Rumpun Keluarga
                    </h3>

                    <p class="text-slate-500 mt-2">
                        Buat rumpun keluarga pertama Anda untuk mulai membangun silsilah.
                    </p>

                </div>
            @endforelse


            <a href="{{ route('keluarga.create') }}"
                class="border-2 border-dashed border-slate-300 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:border-blue-400">

                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4">

                    <i data-lucide="plus"></i>

                </div>

                <h3 class="font-bold">
                    Buat Rumpun Keluarga
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Mulai membuat silsilah keluarga baru.
                </p>

            </a>

        </div>

        <div class="bg-white border rounded-2xl p-6 mt-10">

            <h3 class="font-bold text-lg mb-2">
                Bergabung dengan Keluarga
            </h3>

            <p class="text-slate-500 mb-5">
                Masukkan kode undangan yang diberikan oleh anggota keluarga.
            </p>

            <div class="flex gap-3">

                <input type="text" placeholder="Masukkan kode undangan"
                    class="flex-1 border border-slate-300 rounded-xl px-4 py-3">

                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold">

                    Gabung

                </button>

            </div>

        </div>

    </div>

@endsection
