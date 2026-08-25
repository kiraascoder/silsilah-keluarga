@extends('layouts.guest')

@section('title', 'Lupa Kata Sandi - Silsilahku')

@section('content')

    <section class="max-w-5xl mx-auto px-6 py-20">

        <div class="max-w-xl mx-auto bg-white border border-slate-200 rounded-3xl p-10 shadow-sm">

            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                <i data-lucide="key-round" class="w-8 h-8"></i>
            </div>

            <h2 class="text-3xl font-bold mb-3">
                Lupa Kata Sandi?
            </h2>

            <p class="text-slate-500 mb-8">
                Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>

            @if (session('status'))
                <div class="bg-green-50 text-green-700 rounded-xl p-4 mb-5">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">

                @csrf

                <div>
                    <label class="block mb-2 font-medium">
                        Email
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white rounded-xl py-3 font-semibold">

                    Kirim Tautan Reset

                </button>

            </form>

            <div class="text-center mt-7">

                <a href="{{ route('login') }}" class="text-blue-600 text-sm font-medium">

                    ← Kembali ke halaman masuk

                </a>

            </div>

        </div>

    </section>

@endsection
