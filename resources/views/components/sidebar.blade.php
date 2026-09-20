<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-slate-200 bg-white lg:flex lg:flex-col">
    {{-- =========================================================
        LOGO
    ========================================================== --}}
    <div class="flex h-20 shrink-0 items-center border-b border-slate-200 px-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            {{-- Logo Aplikasi --}}
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white">
                {{-- SVG Logo Silsilah --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" aria-hidden="true">
                    <path d="M12 3v18" />
                    <path d="M12 6H7a3 3 0 0 0-3 3v1" />
                    <path d="M12 6h5a3 3 0 0 1 3 3v1" />
                    <path d="M4 10v2a3 3 0 0 0 3 3h2" />
                    <path d="M20 10v2a3 3 0 0 1-3 3h-2" />
                    <path d="M9 15v2a3 3 0 0 1-3 3H5" />
                    <path d="M15 15v2a3 3 0 0 0 3 3h1" />
                </svg>
            </div>

            {{-- Nama Aplikasi --}}
            <div class="min-w-0">
                <p class="truncate text-sm font-bold text-slate-900">
                    Silsilah Keluarga
                </p>

                <p class="truncate text-xs text-slate-400">
                    Manajemen Keluarga
                </p>
            </div>
        </a>
    </div>


    {{-- =========================================================
        NAVIGATION
    ========================================================== --}}
    <nav class="flex-1 overflow-y-auto px-4 py-6">

        {{-- =====================================================
            UTAMA
        ====================================================== --}}
        <div class="mb-6">

            <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Utama
            </p>

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                    {{ request()->routeIs('dashboard')
                        ? 'bg-blue-50 font-semibold text-blue-600'
                        : 'text-slate-600 hover:bg-slate-50' }}">
                {{-- Dashboard Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 shrink-0"
                    aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>

                <span>
                    Dashboard
                </span>
            </a>
        </div>


        {{-- =====================================================
            SILSILAH
        ====================================================== --}}
        <div class="mb-6">

            <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Silsilah
            </p>


            {{-- Pohon Silsilah --}}
            <a href="{{ route('pohon.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                    {{ request()->routeIs('pohon.*')
                        ? 'bg-blue-50 font-semibold text-blue-600'
                        : 'text-slate-600 hover:bg-slate-50' }}">
                {{-- Tree / Branch Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 shrink-0"
                    aria-hidden="true">
                    <path d="M12 3v18" />

                    <path d="M12 7H7a3 3 0 0 0-3 3v1" />
                    <path d="M12 7h5a3 3 0 0 1 3 3v1" />

                    <path d="M4 11v1a3 3 0 0 0 3 3h2" />
                    <path d="M20 11v1a3 3 0 0 1-3 3h-2" />

                    <circle cx="12" cy="3" r="1.5" />
                    <circle cx="4" cy="11" r="1.5" />
                    <circle cx="20" cy="11" r="1.5" />
                    <circle cx="7" cy="15" r="1.5" />
                    <circle cx="17" cy="15" r="1.5" />
                </svg>

                <span>
                    Pohon Silsilah
                </span>
            </a>


            {{-- Anggota Keluarga --}}
            <a href="{{ route('anggota.index') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                    {{ request()->routeIs('anggota.*')
                        ? 'bg-blue-50 font-semibold text-blue-600'
                        : 'text-slate-600 hover:bg-slate-50' }}">
                {{-- Users Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 shrink-0"
                    aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />

                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>

                <span>
                    Anggota Keluarga
                </span>
            </a>
        </div>


        {{-- =====================================================
            AKUN
        ====================================================== --}}
        <div>

            <p class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Akun
            </p>


            {{-- Profil --}}
            <a href="{{ route('profile.edit') }}"
                class="mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm transition
                    {{ request()->routeIs('profile.*')
                        ? 'bg-blue-50 font-semibold text-blue-600'
                        : 'text-slate-600 hover:bg-slate-50' }}">
                {{-- User Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 shrink-0"
                    aria-hidden="true">
                    <circle cx="12" cy="7" r="4" />
                    <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
                </svg>

                <span>
                    Akun
                </span>
            </a>

        </div>

    </nav>


    {{-- =========================================================
        LOGOUT
    ========================================================== --}}
    <div class="shrink-0 border-t border-slate-200 p-4">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm text-slate-600 transition hover:bg-red-50 hover:text-red-600">
                {{-- Logout Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 shrink-0"
                    aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>

                <span>
                    Keluar
                </span>
            </button>
        </form>

    </div>

</aside>
