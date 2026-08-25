@extends('layouts.guest')

@section('title', 'Masuk - Silsilahku')

@section('content')

    <section class="max-w-6xl mx-auto px-6 py-16">

        <div class="grid grid-cols-2 gap-12 items-center">

            <div class="bg-slate-100 rounded-3xl p-12 min-h-[520px] flex flex-col justify-center">

                <div class="w-20 h-20 rounded-2xl bg-white flex items-center justify-center shadow-sm mb-8">
                    <i data-lucide="git-fork" class="w-10 h-10 text-blue-600"></i>
                </div>

                <h2 class="text-4xl font-bold mb-4">
                    Selamat Datang Kembali
                </h2>

                <p class="text-slate-500 text-lg leading-relaxed">
                    Masuk untuk melihat dan mengelola pohon silsilah keluarga Anda.
                </p>

            </div>

            <div class="bg-white border border-slate-200 rounded-3xl p-10 shadow-sm">

                <h2 class="text-3xl font-bold mb-2">
                    Masuk
                </h2>

                <p class="text-slate-500 mb-8">
                    Masukkan email dan kata sandi Anda.
                </p>

                @if (session('status'))
                    <div class="mb-5 bg-green-50 text-green-700 rounded-lg p-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block mb-2 font-medium">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Kata Sandi
                        </label>

                        <input type="password" name="password" required
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500">

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">

                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="remember" class="rounded border-slate-300">

                            Ingat saya
                        </label>

                        <a href="{{ route('password.request') }}" class="text-blue-600 text-sm">

                            Lupa kata sandi?

                        </a>

                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-semibold">

                        Masuk

                    </button>

                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Belum memiliki akun?

                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold">
                        Daftar sekarang
                    </a>
                </p>

            </div>

        </div>

    </section>

@endsection
