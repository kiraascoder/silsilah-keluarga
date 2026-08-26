<aside class="fixed top-20 bottom-0 left-0 w-64
           bg-white border-r border-slate-200">

    <div class="h-full flex flex-col p-5">

        {{-- Dashboard --}}
        <nav class="space-y-2">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('dashboard')
                    ? 'bg-blue-50 text-blue-600 font-semibold'
                    : 'text-slate-600 hover:bg-slate-50' }}">

                <i data-lucide="layout-dashboard" class="w-5 h-5">
                </i>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- Silsilah --}}
            <p
                class="px-4 pt-6 pb-2
                       text-xs font-semibold uppercase
                       tracking-wider text-slate-400">

                Silsilah

            </p>


            <a href="{{ route('pohon.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('pohon.*')
                    ? 'bg-blue-50 text-blue-600 font-semibold'
                    : 'text-slate-600 hover:bg-slate-50' }}">

                <i data-lucide="git-fork" class="w-5 h-5">
                </i>

                <span>
                    Pohon Silsilah
                </span>

            </a>


            <a href="{{ route('anggota.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('anggota.*')
                    ? 'bg-blue-50 text-blue-600 font-semibold'
                    : 'text-slate-600 hover:bg-slate-50' }}">

                <i data-lucide="users" class="w-5 h-5">
                </i>

                <span>
                    Anggota Keluarga
                </span>

            </a>


            {{-- Akun --}}
            <p
                class="px-4 pt-6 pb-2
                       text-xs font-semibold uppercase
                       tracking-wider text-slate-400">

                Akun

            </p>


            <a href="{{ route('profil.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('profil.*')
                    ? 'bg-blue-50 text-blue-600 font-semibold'
                    : 'text-slate-600 hover:bg-slate-50' }}">

                <i data-lucide="user" class="w-5 h-5">
                </i>

                <span>
                    Profil Saya
                </span>

            </a>


            <a href="{{ route('pengaturan.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                {{ request()->routeIs('pengaturan.*')
                    ? 'bg-blue-50 text-blue-600 font-semibold'
                    : 'text-slate-600 hover:bg-slate-50' }}">

                <i data-lucide="settings" class="w-5 h-5">
                </i>

                <span>
                    Pengaturan
                </span>

            </a>

        </nav>


        {{-- Logout --}}
        <div class="mt-auto pt-5 border-t border-slate-200">

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="w-full flex items-center gap-3
                           px-4 py-3 rounded-xl
                           text-slate-600
                           hover:bg-red-50 hover:text-red-600
                           transition">

                    <i data-lucide="log-out" class="w-5 h-5">
                    </i>

                    <span>
                        Keluar
                    </span>

                </button>

            </form>

        </div>

    </div>

</aside>
