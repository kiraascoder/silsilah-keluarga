<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title ?? config('app.name', 'Silsilah Keluarga') }}
    </title>


    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">


    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>


<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <div class="min-h-screen">

        {{-- Sidebar --}}
        @include('components.sidebar')


        {{-- Konten utama --}}
        <main class="lg:ml-64 min-h-screen">

            <div class="p-6 lg:p-8">

                {{-- Success --}}
                @if (session('success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

                        {{ session('success') }}

                    </div>
                @endif


                {{-- Error --}}
                @if (session('error'))
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                        {{ session('error') }}

                    </div>
                @endif


                {{-- Validation --}}
                @if ($errors->any())

                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                        <p class="mb-2 font-semibold text-red-700">
                            Terdapat kesalahan:
                        </p>

                        <ul class="list-inside list-disc space-y-1 text-sm text-red-600">

                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- Konten dari x-app-layout --}}
                {{ $slot }}

            </div>

        </main>

    </div>


    @stack('scripts')

</body>

</html>
