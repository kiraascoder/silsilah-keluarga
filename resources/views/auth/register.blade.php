@extends('layouts.guest')

@section('title', 'Daftar - Silsilahku')

@section('content')

    <section class="max-w-6xl mx-auto px-6 py-16">

        <div class="grid grid-cols-2 gap-12 items-center">

            <div class="bg-slate-100 rounded-3xl p-12 min-h-[600px] flex flex-col justify-center">

                <div class="w-20 h-20 rounded-2xl bg-white flex items-center justify-center shadow-sm mb-8">
                    <i data-lucide="users" class="w-10 h-10 text-blue-600"></i>
                </div>

                <h2 class="text-4xl font-bold mb-4">
                    Mulai Bangun Silsilah Keluarga
                </h2>

                <p class="text-slate-500 text-lg leading-relaxed">
                    Buat akun untuk mulai mencatat anggota keluarga dan membangun pohon silsilah secara digital.
                </p>

            </div>

            <div class="bg-white border border-slate-200 rounded-3xl p-10 shadow-sm">

                <h2 class="text-3xl font-bold mb-2">
                    Daftar Akun
                </h2>

                <p class="text-slate-500 mb-8">
                    Lengkapi data berikut untuk membuat akun baru.
                </p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block mb-2 font-medium">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2 font-medium">
                            Nomor Telepon
                        </label>

                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                        @error('phone')
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
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">

                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">
                            Konfirmasi Kata Sandi
                        </label>

                        <input type="password" name="password_confirmation" required
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-semibold">

                        Daftar Akun

                    </button>

                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Sudah memiliki akun?

                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold">
                        Masuk
                    </a>
                </p>

            </div>

        </div>

    </section>

@endsection
