<x-app-layout>

    <div class="max-w-7xl mx-auto">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-8 flex items-start justify-between gap-6">

            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Undangan Keluarga
                </h1>

                <p class="mt-1 text-slate-500">
                    Kelola undangan untuk anggota keluarga yang ingin bergabung.
                </p>
            </div>

            <a href="{{ route('undangan.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <i data-lucide="plus" class="h-5 w-5"></i>
                Buat Undangan
            </a>

        </div>


        {{-- =========================================================
            SUCCESS
        ========================================================== --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">

                <i data-lucide="check-circle" class="mt-0.5 h-5 w-5 shrink-0"></i>

                <div>
                    {{ session('success') }}
                </div>

            </div>
        @endif


        {{-- =========================================================
            ERROR
        ========================================================== --}}
        @if (session('error'))
            <div
                class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">

                <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0"></i>

                <div>
                    {{ session('error') }}
                </div>

            </div>
        @endif


        {{-- =========================================================
            RINGKASAN
        ========================================================== --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

            {{-- Total --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Undangan
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ $undangan->count() }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <i data-lucide="mail" class="h-5 w-5"></i>
                    </div>

                </div>

            </div>


            {{-- Menunggu --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Menunggu
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ $undangan->where('status', 'menunggu')->count() }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600">
                        <i data-lucide="clock-3" class="h-5 w-5"></i>
                    </div>

                </div>

            </div>


            {{-- Diterima --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Diterima
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ $undangan->where('status', 'diterima')->count() }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-600">
                        <i data-lucide="user-check" class="h-5 w-5"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            DAFTAR UNDANGAN
        ========================================================== --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">

            {{-- Header tabel --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Daftar Undangan
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Undangan yang telah dibuat untuk keluarga.
                        </p>
                    </div>

                </div>

            </div>


            @if ($undangan->count())

                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full text-left">

                        <thead class="border-b border-slate-200 bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Penerima
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Dibuat Oleh
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Tanggal
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($undangan as $item)
                                <tr class="transition hover:bg-slate-50">

                                    {{-- Penerima --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">

                                                <i data-lucide="mail" class="h-5 w-5"></i>

                                            </div>

                                            <div>

                                                <p class="font-semibold text-slate-900">
                                                    {{ $item->email ?? ($item->nama ?? '-') }}
                                                </p>

                                                @if (isset($item->nama))
                                                    <p class="text-sm text-slate-500">
                                                        {{ $item->email ?? '-' }}
                                                    </p>
                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Pembuat --}}
                                    <td class="px-6 py-4">

                                        <p class="text-sm text-slate-700">
                                            {{ $item->pembuat->name ?? '-' }}
                                        </p>

                                    </td>


                                    {{-- Status --}}
                                    <td class="px-6 py-4">

                                        @php
                                            $status = $item->status ?? 'menunggu';

                                            $statusClass = match ($status) {
                                                'diterima' => 'bg-green-50 text-green-700 border-green-200',
                                                'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                                'kadaluarsa' => 'bg-slate-100 text-slate-600 border-slate-200',
                                                default => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                            };
                                        @endphp

                                        <span
                                            class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                    </td>


                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4">

                                        <p class="text-sm text-slate-600">
                                            {{ $item->created_at?->format('d M Y') ?? '-' }}
                                        </p>

                                    </td>


                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            @if (isset($item->token))
                                                <button type="button"
                                                    onclick="navigator.clipboard.writeText('{{ url('/undangan/' . $item->token) }}')"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:bg-slate-50 hover:text-blue-600"
                                                    title="Salin tautan">
                                                    <i data-lucide="copy" class="h-4 w-4"></i>
                                                </button>
                                            @endif

                                            @if (isset($item->id))
                                                <form method="POST"
                                                    action="{{ route('undangan.destroy', $item->id) }}"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus undangan ini?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-500 transition hover:bg-red-50"
                                                        title="Hapus">
                                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Mobile --}}
                <div class="divide-y divide-slate-100 md:hidden">

                    @foreach ($undangan as $item)
                        <div class="p-5">

                            <div class="flex items-start justify-between gap-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">

                                        <i data-lucide="mail" class="h-5 w-5"></i>

                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            {{ $item->email ?? ($item->nama ?? '-') }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ $item->created_at?->format('d M Y') ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                                @php
                                    $status = $item->status ?? 'menunggu';

                                    $statusClass = match ($status) {
                                        'diterima' => 'bg-green-50 text-green-700 border-green-200',
                                        'ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                        'kadaluarsa' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        default => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    };
                                @endphp

                                <span
                                    class="shrink-0 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>

                            </div>

                            <div class="mt-4 flex justify-end gap-2">

                                @if (isset($item->token))
                                    <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ url('/undangan/' . $item->token) }}')"
                                        class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">
                                        <i data-lucide="copy" class="h-4 w-4"></i>
                                        Salin Link
                                    </button>
                                @endif

                                @if (isset($item->id))
                                    <form method="POST" action="{{ route('undangan.destroy', $item->id) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus undangan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            Hapus
                                        </button>

                                    </form>
                                @endif

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                {{-- Empty state --}}
                <div class="px-6 py-16 text-center">

                    <div
                        class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

                        <i data-lucide="mail-plus" class="h-7 w-7"></i>

                    </div>

                    <h3 class="font-semibold text-slate-900">
                        Belum ada undangan
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        Buat undangan untuk mengajak anggota keluarga
                        bergabung ke dalam silsilah keluarga.
                    </p>

                    <a href="{{ route('undangan.create') }}"
                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        <i data-lucide="plus" class="h-5 w-5"></i>
                        Buat Undangan
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
