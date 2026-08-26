<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'SILSILAHKU') }}
    </title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide Icon --}}
    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800">

    <div class="min-h-screen">

        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content --}}
        <main class="ml-64 pt-20 min-h-screen">

            <div class="p-8">

                {{-- Flash Success --}}
                @if (session('success'))
                    <div
                        class="mb-6 flex items-center gap-3
                               rounded-xl border border-emerald-200
                               bg-emerald-50 px-5 py-4
                               text-emerald-700">

                        <i data-lucide="circle-check" class="w-5 h-5"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>
                @endif


                {{-- Flash Error --}}
                @if (session('error'))
                    <div
                        class="mb-6 flex items-center gap-3
                               rounded-xl border border-red-200
                               bg-red-50 px-5 py-4
                               text-red-700">

                        <i data-lucide="circle-alert" class="w-5 h-5"></i>

                        <span>
                            {{ session('error') }}
                        </span>

                    </div>
                @endif


                {{-- Validation --}}
                @if ($errors->any())

                    <div
                        class="mb-6 rounded-xl
                               border border-red-200
                               bg-red-50 px-5 py-4
                               text-red-700">

                        <div class="flex items-center gap-2 font-semibold mb-2">

                            <i data-lucide="circle-alert" class="w-5 h-5"></i>

                            Terjadi kesalahan

                        </div>

                        <ul class="list-disc ml-7 space-y-1 text-sm">

                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- Konten Halaman --}}
                {{ $slot }}

            </div>

        </main>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

</body>

</html>
