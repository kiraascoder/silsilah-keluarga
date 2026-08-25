<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Silsilahku')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen">

    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">

            <a href="/" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <i data-lucide="git-fork"></i>
                </div>

                <div>
                    <h1 class="font-bold text-xl">SILSILAHKU</h1>
                    <p class="text-xs text-slate-500">
                        Pohon Silsilah Keluarga
                    </p>
                </div>
            </a>

            <nav class="flex items-center gap-8 text-sm">
                <a href="/" class="hover:text-blue-600">Beranda</a>

                @guest
                    <a href="{{ route('login') }}" class="hover:text-blue-600">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg">
                        Daftar
                    </a>
                @endguest
            </nav>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white mt-20">

        <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-4 gap-10">

            <div>
                <h3 class="font-bold text-lg mb-3">
                    SILSILAHKU
                </h3>

                <p class="text-sm text-slate-500">
                    Platform untuk mencatat dan melestarikan silsilah keluarga secara digital.
                </p>
            </div>

            <div>
                <h4 class="font-semibold mb-3">
                    Navigasi
                </h4>

                <div class="space-y-2 text-sm text-slate-500">
                    <p>Beranda</p>
                    <p>Masuk</p>
                    <p>Daftar</p>
                </div>
            </div>

            <div>
                <h4 class="font-semibold mb-3">
                    Bantuan
                </h4>

                <div class="space-y-2 text-sm text-slate-500">
                    <p>Panduan Penggunaan</p>
                    <p>Privasi</p>
                    <p>Ketentuan</p>
                </div>
            </div>

            <div>
                <h4 class="font-semibold mb-3">
                    Tentang
                </h4>

                <p class="text-sm text-slate-500">
                    Sistem informasi pohon silsilah keluarga berbasis website.
                </p>
            </div>

        </div>

        <div class="border-t text-center py-5 text-sm text-slate-400">
            © {{ date('Y') }} SILSILAHKU
        </div>

    </footer>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>
