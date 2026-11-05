@extends('layouts.guest')

@section('title', 'Masuk - Silsilahku')

@section('content')

    <section class="max-w-6xl mx-auto px-6 py-16">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">


            {{-- =====================================================
                PANEL SELAMAT DATANG
            ====================================================== --}}
            <div
                class="relative
                       min-h-[520px]
                       overflow-hidden
                       rounded-3xl
                       bg-slate-200">

                {{-- Background --}}
                <img
                    src="{{ asset('gunung.png') }}"
                    alt="Silsilah Keluarga"
                    class="absolute inset-0
                           h-full
                           w-full
                           object-cover"
                >

                {{-- Overlay --}}
                <div
                    class="absolute inset-0
                           bg-slate-900/45">
                </div>

                {{-- Konten --}}
                <div
                    class="relative z-10
                           flex
                           h-full
                           min-h-[520px]
                           flex-col
                           justify-end
                           p-12
                           text-white">

                    <div
                        class="mb-6
                               flex
                               h-20
                               w-20
                               items-center
                               justify-center
                               rounded-2xl
                               bg-white
                               text-blue-600
                               shadow-lg">

                        <i
                            data-lucide="git-fork"
                            class="h-10 w-10">
                        </i>

                    </div>


                    <h2
                        class="mb-4
                               text-4xl
                               font-bold
                               leading-tight">

                        Selamat Datang<br>
                        Kembali

                    </h2>


                    <p
                        class="max-w-md
                               text-lg
                               leading-relaxed
                               text-white/90">

                        Masuk untuk melihat dan mengelola
                        pohon silsilah keluarga Anda.

                    </p>

                </div>

            </div>


            {{-- =====================================================
                FORM LOGIN
            ====================================================== --}}
            <div
                class="bg-white
                       border border-slate-200
                       rounded-3xl
                       p-8 md:p-10
                       shadow-sm">

                {{-- Heading --}}
                <h2
                    class="text-3xl
                           font-bold
                           text-slate-900
                           mb-2">

                    Masuk

                </h2>


                <p class="text-slate-500 mb-8">

                    Masukkan email dan kata sandi Anda.

                </p>


                {{-- =================================================
                    STATUS
                ================================================== --}}
                @if (session('status'))

                    <div
                        class="mb-5
                               bg-green-50
                               border border-green-200
                               text-green-700
                               rounded-xl
                               p-4
                               text-sm">

                        {{ session('status') }}

                    </div>

                @endif


                {{-- =================================================
                    FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="space-y-5">

                    @csrf


                    {{-- =================================================
                        EMAIL
                    ================================================== --}}
                    <div>

                        <label
                            for="email"
                            class="block
                                   mb-2
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            Email

                        </label>


                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@email.com"
                            class="w-full
                                   border border-slate-300
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-100"
                        >


                        @error('email')

                            <p
                                class="text-red-500
                                       text-sm
                                       mt-1">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                        PASSWORD
                    ================================================== --}}
                    <div>

                        <label
                            for="password"
                            class="block
                                   mb-2
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            Kata Sandi

                        </label>


                        {{-- Password wrapper --}}
                        <div class="relative">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="w-full
                                       border border-slate-300
                                       rounded-xl
                                       px-4 py-3
                                       pr-12
                                       outline-none
                                       transition
                                       focus:border-blue-500
                                       focus:ring-2
                                       focus:ring-blue-100"
                            >


                            {{-- Toggle password --}}
                            <button
                                type="button"
                                id="togglePassword"
                                aria-label="Tampilkan kata sandi"
                                class="absolute
                                       right-3
                                       top-1/2
                                       -translate-y-1/2
                                       flex
                                       items-center
                                       justify-center
                                       w-8
                                       h-8
                                       rounded-lg
                                       text-slate-400
                                       hover:text-slate-600
                                       hover:bg-slate-100
                                       transition
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-100">

                                <i
                                    id="passwordEye"
                                    data-lucide="eye"
                                    class="w-5 h-5">
                                </i>

                            </button>

                        </div>


                        @error('password')

                            <p
                                class="text-red-500
                                       text-sm
                                       mt-1">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                        REMEMBER + FORGOT PASSWORD
                    ================================================== --}}
                    <div
                        class="flex
                               items-center
                               justify-between">

                        <label
                            class="flex
                                   items-center
                                   gap-2
                                   text-sm
                                   text-slate-600">

                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded
                                       border-slate-300
                                       text-blue-600
                                       focus:ring-blue-500"
                            >

                            Ingat saya

                        </label>


                        @if (Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="text-blue-600
                                       hover:text-blue-700
                                       text-sm
                                       font-medium">

                                Lupa kata sandi?

                            </a>

                        @endif

                    </div>


                    {{-- =================================================
                        BUTTON LOGIN
                    ================================================== --}}
                    <button
                        type="submit"
                        class="w-full
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               rounded-xl
                               py-3
                               font-semibold
                               transition
                               flex
                               items-center
                               justify-center
                               gap-2">

                        <i
                            data-lucide="log-in"
                            class="w-4 h-4">
                        </i>

                        Masuk

                    </button>

                </form>


                {{-- =================================================
                    REGISTER
                ================================================== --}}
                @if (Route::has('register'))

                    <p
                        class="text-center
                               text-sm
                               text-slate-500
                               mt-8">

                        Belum memiliki akun?

                        <a
                            href="{{ route('register') }}"
                            class="text-blue-600
                                   hover:text-blue-700
                                   font-semibold">

                            Daftar sekarang

                        </a>

                    </p>

                @endif

            </div>

        </div>

    </section>


    {{-- =========================================================
        JAVASCRIPT
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
             * =====================================================
             * INITIALIZE LUCIDE
             * =====================================================
             */

            if (typeof lucide !== 'undefined') {

                lucide.createIcons();

            }


            /*
             * =====================================================
             * PASSWORD TOGGLE
             *
             * PASSWORD HIDDEN
             *      ↓
             *      👁
             *
             * PASSWORD VISIBLE
             *      ↓
             *      👁‍🗨
             *
             * Bisa diklik berkali-kali:
             *
             * eye
             * eye-off
             * eye
             * eye-off
             * ...
             * =====================================================
             */

            const passwordInput =
                document.getElementById('password');

            const togglePassword =
                document.getElementById('togglePassword');

            const passwordEye =
                document.getElementById('passwordEye');


            if (
                passwordInput &&
                togglePassword &&
                passwordEye
            ) {

                togglePassword.addEventListener(
                    'click',
                    function () {

                        /*
                         * Cek kondisi saat ini.
                         *
                         * true  = password masih tersembunyi
                         * false = password sedang terlihat
                         */

                        const isHidden =
                            passwordInput.type === 'password';


                        /*
                         * Ubah tipe input
                         */

                        passwordInput.type =
                            isHidden
                                ? 'text'
                                : 'password';


                        /*
                         * Ubah accessibility label
                         */

                        togglePassword.setAttribute(
                            'aria-label',
                            isHidden
                                ? 'Sembunyikan kata sandi'
                                : 'Tampilkan kata sandi'
                        );


                        /*
                         * Ubah icon
                         */

                        passwordEye.setAttribute(
                            'data-lucide',
                            isHidden
                                ? 'eye-off'
                                : 'eye'
                        );


                        /*
                         * Render ulang Lucide.
                         */

                        if (typeof lucide !== 'undefined') {

                            lucide.createIcons();

                        }

                    }
                );

            }

        });

    </script>

@endsection
