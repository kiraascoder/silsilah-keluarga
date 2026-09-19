@extends('layouts.member')

@section('title', 'Buat Undangan')

@section('content')

    <div class="max-w-2xl mx-auto">

        {{-- Breadcrumb --}}

        <div class="mb-8">

            <div class="flex items-center gap-2 text-sm mb-3">

                <a href="{{ route('undangan.index') }}" class="text-blue-600 hover:underline">
                    Undangan Keluarga
                </a>

                <span class="text-slate-400">
                    /
                </span>

                <span class="text-slate-500">
                    Buat Undangan
                </span>

            </div>


            <h1 class="text-3xl font-bold text-slate-900">
                Buat Undangan
            </h1>

            <p class="text-slate-500 mt-1">
                Undang pengguna untuk bergabung ke keluarga.
            </p>

        </div>


        @if (session('error'))
            <div
                class="mb-6 rounded-xl
                   border border-red-200
                   bg-red-50
                   px-5 py-4
                   text-sm text-red-700">

                {{ session('error') }}

            </div>
        @endif


        <form method="POST" action="{{ route('undangan.store') }}"
            class="bg-white
               border border-slate-200
               rounded-2xl
               p-7">

            @csrf


            <div>

                <label for="email"
                    class="block
                       text-sm
                       font-semibold
                       text-slate-700
                       mb-2">
                    Email Pengguna
                </label>


                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="contoh@email.com" required autofocus
                    class="w-full
                       border border-slate-300
                       rounded-xl
                       px-4 py-3
                       focus:outline-none
                       focus:ring-2
                       focus:ring-blue-500">


                @error('email')
                    <p class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </p>
                @enderror


                <p class="text-xs text-slate-400 mt-2">
                    Undangan berlaku selama 7 hari.
                </p>

            </div>


            <div class="flex
                   justify-end
                   gap-3
                   mt-8">

                <a href="{{ route('undangan.index') }}"
                    class="border
                       border-slate-300
                       rounded-xl
                       px-5 py-3
                       font-medium
                       hover:bg-slate-50">
                    Batal
                </a>


                <button type="submit"
                    class="bg-blue-600
                       hover:bg-blue-700
                       text-white
                       rounded-xl
                       px-5 py-3
                       font-semibold">

                    Buat Undangan

                </button>

            </div>

        </form>

    </div>

@endsection
