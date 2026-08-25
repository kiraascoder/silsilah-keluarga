<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Silsilahku')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>

</head>

<body class="bg-slate-50 text-slate-800">

    <header class="bg-white border-b h-20">

        <div class="max-w-7xl mx-auto px-6 h-full flex justify-between items-center">

            <a href="/" class="flex items-center gap-3">

                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="git-fork"></i>
                </div>

                <div>
                    <h1 class="font-bold text-xl">
                        SILSILAHKU
                    </h1>

                    <p class="text-xs text-slate-500">
                        Pohon Silsilah Keluarga
                    </p>
                </div>

            </a>

            <div class="flex items-center gap-4">

                <div class="text-right">

                    <p class="font-semibold">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-slate-500">
                        Pengguna
                    </p>

                </div>

                <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                    <i data-lucide="user"></i>
                </div>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button class="border rounded-lg px-4 py-2">

                        Keluar

                    </button>

                </form>

            </div>

        </div>

    </header>

    <main class="py-12 px-6">

        @yield('content')

    </main>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>
