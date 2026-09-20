<x-app-layout>

    <div class="mx-auto max-w-3xl">

        {{-- Header --}}
        <div class="mb-8">

            <div class="mb-4">
                <a href="{{ route('undangan.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-600">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Kembali ke Undangan
                </a>
            </div>

            <h1 class="text-3xl font-bold text-slate-900">
                Buat Undangan Keluarga
            </h1>

            <p class="mt-2 text-slate-500">
                Undang anggota keluarga untuk bergabung ke dalam keluarga ini.
            </p>

        </div>


        {{-- Error --}}
        @if ($errors->any())

            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                <div class="flex gap-3">

                    <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0 text-red-600"></i>

                    <div>

                        <p class="font-semibold text-red-800">
                            Undangan tidak dapat dibuat
                        </p>

                        <ul class="mt-2 space-y-1 text-sm text-red-700">

                            @foreach ($errors->all() as $error)
                                <li>
                                    • {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Session Error --}}
        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                <div class="flex gap-3">

                    <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0 text-red-600"></i>

                    <p class="text-sm text-red-700">
                        {{ session('error') }}
                    </p>

                </div>

            </div>
        @endif


        {{-- Form Card --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                        <i data-lucide="mail-plus" class="h-6 w-6"></i>

                    </div>

                    <div>

                        <h2 class="font-bold text-slate-900">
                            Informasi Undangan
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Masukkan email pengguna yang ingin diundang.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Form --}}
            <form action="{{ route('undangan.store') }}" method="POST">

                @csrf

                <div class="space-y-6 px-6 py-6">

                    {{-- Email --}}
                    <div>

                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Email
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>

                            </div>

                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="contoh@email.com" autocomplete="email" required maxlength="150"
                                class="w-full rounded-xl border border-slate-300 bg-white py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            Gunakan email yang terdaftar atau akan digunakan oleh anggota keluarga.
                        </p>

                    </div>


                    {{-- Informasi --}}
                    <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">

                        <div class="flex gap-3">

                            <i data-lucide="info" class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"></i>

                            <div class="text-sm text-blue-800">

                                <p class="font-semibold">
                                    Informasi undangan
                                </p>

                                <ul class="mt-2 space-y-1.5 text-blue-700">

                                    <li>
                                        • Undangan berlaku selama 7 hari.
                                    </li>

                                    <li>
                                        • Satu email tidak dapat memiliki undangan aktif yang sama.
                                    </li>

                                    <li>
                                        • Penerima harus masuk menggunakan email yang sesuai dengan undangan.
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <div
                    class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">

                    <a href="{{ route('undangan.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">

                        <i data-lucide="send" class="h-4 w-4"></i>

                        Buat Undangan

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
