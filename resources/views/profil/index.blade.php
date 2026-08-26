@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

    <div class="max-w-5xl">

        <div class="mb-7">
            <h2 class="text-3xl font-bold">
                Profil Saya
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola informasi akun Anda.
            </p>
        </div>


        <div class="bg-white border border-slate-200 rounded-2xl">

            {{-- Header profil --}}
            <div class="p-7 border-b border-slate-200">

                <div class="flex items-center gap-5">

                    <div
                        class="w-24 h-24 bg-slate-100 rounded-full
                            flex items-center justify-center">

                        <i data-lucide="user" class="w-10 h-10 text-slate-400"></i>

                    </div>

                    <div>
                        <h3 class="text-2xl font-bold">
                            {{ auth()->user()->name }}
                        </h3>

                        <p class="text-slate-500">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                </div>

            </div>


            <form class="p-7">

                <h3 class="font-bold text-lg mb-6">
                    Informasi Akun
                </h3>

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block font-medium mb-2">
                            Nama Lengkap
                        </label>

                        <input type="text" value="{{ auth()->user()->name }}"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Email
                        </label>

                        <input type="email" value="{{ auth()->user()->email }}"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>


                    <div>
                        <label class="block font-medium mb-2">
                            Nomor Telepon
                        </label>

                        <input type="text" value="{{ auth()->user()->phone ?? '' }}" placeholder="Masukkan nomor telepon"
                            class="w-full border border-slate-300
                               rounded-xl px-4 py-3">
                    </div>

                </div>


                <div class="flex justify-end mt-7">

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700
                           text-white rounded-xl px-6 py-3
                           font-semibold">

                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
