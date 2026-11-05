@extends('layouts.guest')

@section('title', 'Daftar - Silsilahku')

@section('content')

    <section class="max-w-6xl mx-auto px-6 py-16">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- =====================================================
                PANEL SELAMAT DATANG
            ====================================================== --}}
            <div class="relative min-h-[600px] overflow-hidden rounded-3xl bg-slate-200">

                {{-- Background --}}
                <img
                    src="{{ asset('gunung.png') }}"
                    alt="Silsilah Keluarga"
                    class="absolute inset-0 h-full w-full object-cover"
                >

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-slate-900/45"></div>

                {{-- Konten --}}
                <div
                    class="relative z-10 flex h-full min-h-[600px]
                           flex-col justify-end p-12 text-white">

                    <div
                        class="mb-6 flex h-20 w-20 items-center justify-center
                               rounded-2xl bg-white text-blue-600 shadow-lg">

                        <i data-lucide="users" class="h-10 w-10"></i>

                    </div>

                    <h2 class="mb-4 text-4xl font-bold leading-tight">
                        Mulai Bangun<br>
                        Silsilah Keluarga
                    </h2>

                    <p class="max-w-md text-lg leading-relaxed text-white/90">
                        Buat akun untuk mulai mencatat anggota keluarga
                        dan membangun pohon silsilah secara digital.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                FORM REGISTER
            ====================================================== --}}
            <div
                class="bg-white
                       border border-slate-200
                       rounded-3xl
                       p-8 md:p-10
                       shadow-sm">

                <h2 class="text-3xl font-bold text-slate-900 mb-2">
                    Daftar Akun
                </h2>

                <p class="text-slate-500 mb-8">
                    Lengkapi data berikut untuk membuat akun baru.
                </p>


                {{-- =================================================
                    FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="space-y-5">

                    @csrf


                    {{-- =================================================
                        NAMA
                    ================================================== --}}
                    <div>

                        <label
                            for="name"
                            class="block mb-2
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            Nama Lengkap

                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            class="w-full
                                   border border-slate-300
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-100"
                            placeholder="Masukkan nama lengkap"
                        >

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                        EMAIL
                    ================================================== --}}
                    <div>

                        <label
                            for="email"
                            class="block mb-2
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
                            autocomplete="username"
                            class="w-full
                                   border border-slate-300
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-100"
                            placeholder="nama@email.com"
                        >

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                        NOMOR TELEPON
                    ================================================== --}}
                    <div>

                        <label
                            for="phone"
                            class="block mb-2
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            Nomor Telepon

                        </label>

                        <input
                            id="phone"
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            class="w-full
                                   border border-slate-300
                                   rounded-xl
                                   px-4 py-3
                                   outline-none
                                   transition
                                   focus:border-blue-500
                                   focus:ring-2
                                   focus:ring-blue-100"
                            placeholder="08xxxxxxxxxx"
                        >

                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">
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
                            class="block mb-2
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            Kata Sandi

                        </label>

                        <div class="relative">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="w-full
                                       border border-slate-300
                                       rounded-xl
                                       px-4 py-3 pr-12
                                       outline-none
                                       transition
                                       focus:border-blue-500
                                       focus:ring-2
                                       focus:ring-blue-100"
                                placeholder="Masukkan kata sandi"
                            >

                            {{-- Toggle Password --}}
                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute
                                       right-3
                                       top-1/2
                                       -translate-y-1/2
                                       text-slate-400
                                       hover:text-slate-600
                                       transition"
                                aria-label="Tampilkan kata sandi">

                                <i
                                    id="passwordEye"
                                    data-lucide="eye"
                                    class="w-5 h-5">
                                </i>

                            </button>

                        </div>

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                        KONFIRMASI PASSWORD
                    ================================================== --}}
                    <div>

                        <label
                            for="password_confirmation"
                            class="block mb-2
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            Konfirmasi Kata Sandi

                        </label>

                        <div class="relative">

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="w-full
                                       border border-slate-300
                                       rounded-xl
                                       px-4 py-3 pr-12
                                       outline-none
                                       transition
                                       focus:border-blue-500
                                       focus:ring-2
                                       focus:ring-blue-100"
                                placeholder="Ulangi kata sandi"
                            >

                            {{-- Toggle Confirmation --}}
                            <button
                                type="button"
                                id="togglePasswordConfirmation"
                                class="absolute
                                       right-3
                                       top-1/2
                                       -translate-y-1/2
                                       text-slate-400
                                       hover:text-slate-600
                                       transition"
                                aria-label="Tampilkan konfirmasi kata sandi">

                                <i
                                    id="confirmationEye"
                                    data-lucide="eye"
                                    class="w-5 h-5">
                                </i>

                            </button>

                        </div>

                    </div>


                    {{-- =================================================
                        SUBMIT
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

                        <i data-lucide="user-plus" class="w-4 h-4"></i>

                        Daftar Akun

                    </button>

                </form>


                {{-- =================================================
                    LOGIN
                ================================================== --}}
                <p
                    class="text-center
                           text-sm
                           text-slate-500
                           mt-8">

                    Sudah memiliki akun?

                    <a
                        href="{{ route('login') }}"
                        class="text-blue-600
                               hover:text-blue-700
                               font-semibold">

                        Masuk

                    </a>

                </p>

            </div>

        </div>

    </section>


    {{-- =========================================================
        LUCIDE + PASSWORD TOGGLE
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }


            /*
             * =====================================================
             * PASSWORD
             * =====================================================
             */

            const passwordInput =
                document.getElementById('password');

            const togglePassword =
                document.getElementById('togglePassword');

            if (passwordInput && togglePassword) {

                togglePassword.addEventListener('click', function() {

                    const isPassword =
                        passwordInput.type === 'password';

                    passwordInput.type =
                        isPassword ? 'text' : 'password';

                    togglePassword.setAttribute(
                        'aria-label',
                        isPassword
                            ? 'Sembunyikan kata sandi'
                            : 'Tampilkan kata sandi'
                    );

                    const iconName =
                        isPassword ? 'eye-off' : 'eye';

                    const icon =
                        document.getElementById('passwordEye');

                    if (icon) {

                        icon.setAttribute(
                            'data-lucide',
                            iconName
                        );

                        icon.outerHTML =
                            `<i
                                id="passwordEye"
                                data-lucide="${iconName}"
                                class="w-5 h-5">
                            </i>`;

                        lucide.createIcons();
                    }

                });

            }


            /*
             * =====================================================
             * KONFIRMASI PASSWORD
             * =====================================================
             */

            const confirmationInput =
                document.getElementById(
                    'password_confirmation'
                );

            const toggleConfirmation =
                document.getElementById(
                    'togglePasswordConfirmation'
                );

            if (
                confirmationInput &&
                toggleConfirmation
            ) {

                toggleConfirmation.addEventListener(
                    'click',
                    function() {

                        const isPassword =
                            confirmationInput.type === 'password';

                        confirmationInput.type =
                            isPassword
                                ? 'text'
                                : 'password';

                        toggleConfirmation.setAttribute(
                            'aria-label',
                            isPassword
                                ? 'Sembunyikan konfirmasi kata sandi'
                                : 'Tampilkan konfirmasi kata sandi'
                        );

                        const iconName =
                            isPassword
                                ? 'eye-off'
                                : 'eye';

                        const icon =
                            document.getElementById(
                                'confirmationEye'
                            );

                        if (icon) {

                            icon.setAttribute(
                                'data-lucide',
                                iconName
                            );

                            icon.outerHTML =
                                `<i
                                    id="confirmationEye"
                                    data-lucide="${iconName}"
                                    class="w-5 h-5">
                                </i>`;

                            lucide.createIcons();
                        }

                    }
                );

            }

        });
    </script>

@endsection
