<x-app-layout title="Edit Sejarah">

    <div class="max-w-4xl mx-auto">
        <div class="mb-7">
            <a href="{{ route('sejarah.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-blue-600">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Sejarah
            </a>
            <h1 class="text-3xl font-bold mt-4">Edit Sejarah</h1>
            <p class="text-slate-500 mt-1">Catat peristiwa penting dalam sejarah rumpun keluarga.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sejarah.update', $sejarah->id) }}" class="bg-white border border-slate-200 rounded-2xl p-7 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="judul" class="block font-medium mb-2">Judul</label>
                <input id="judul" name="judul" type="text" value="{{ old('judul', $sejarah->judul ?? '') }}" required maxlength="200" class="w-full border border-slate-300 rounded-xl px-4 py-3">
            </div>
            <div>
                <label for="tanggal" class="block font-medium mb-2">Tanggal</label>
                <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', isset($sejarah) && $sejarah->tanggal ? $sejarah->tanggal->format('Y-m-d') : '') }}" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                <p class="text-xs text-slate-400 mt-2">Kosongkan jika peristiwa tidak memiliki tanggal pasti.</p>
            </div>
            <div>
                <label for="deskripsi" class="block font-medium mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="8" required class="w-full border border-slate-300 rounded-xl px-4 py-3" placeholder="Tuliskan cerita atau informasi sejarah keluarga...">{{ old('deskripsi', $sejarah->deskripsi ?? '') }}</textarea>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('sejarah.index') }}" class="border border-slate-300 rounded-xl px-6 py-3 font-medium hover:bg-slate-50">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        if (typeof lucide !== 'undefined') { lucide.createIcons(); }
    </script>

</x-app-layout>
