<x-app-layout title="Profil">

    <div class="max-w-5xl">

        {{-- Header --}}
        <div class="mb-7">
            <h2 class="text-3xl font-bold text-slate-900">
                Profil
            </h2>

            <p class="text-slate-500 mt-1">
                Kelola informasi profil dan keamanan akun Anda.
            </p>
        </div>


        {{-- Informasi Profil --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-7 mb-6">

            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-900">
                    Informasi Profil
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Perbarui nama dan alamat email akun Anda.
                </p>
            </div>


            {{-- Status berhasil update profil --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    Profil berhasil diperbarui.
                </div>
            @endif


            <form method="POST" action="{{ route('profile.update') }}">

                @csrf
                @method('PATCH')


                <div class="space-y-5">

                    {{-- Nama --}}
                    <div>

                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                            Nama
                        </label>

                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                            required autofocus autocomplete="name"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                        @error('name')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                            Email
                        </label>

                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                            required autocomplete="username"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                        @error('email')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Tombol --}}
                    <div class="flex justify-end pt-2">

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-6 py-3 font-semibold">
                            Simpan Perubahan
                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- Ubah Password --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-7 mb-6">

            <div class="mb-6">

                <h3 class="text-lg font-bold text-slate-900">
                    Ubah Password
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Pastikan akun Anda menggunakan password yang kuat.
                </p>

            </div>


            {{-- Status berhasil update password --}}
            @if (session('status') === 'password-updated')
                <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    Password berhasil diperbarui.
                </div>
            @endif


            <form method="POST" action="{{ route('password.update') }}">

                @csrf
                @method('PUT')


                <div class="space-y-5">

                    {{-- Password Saat Ini --}}
                    <div>

                        <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">
                            Password Saat Ini
                        </label>

                        <input id="current_password" name="current_password" type="password"
                            autocomplete="current-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                        @error('current_password', 'updatePassword')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Password Baru --}}
                    <div>

                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                            Password Baru
                        </label>

                        <input id="password" name="password" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                        @error('password', 'updatePassword')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Konfirmasi Password --}}
                    <div>

                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">
                            Konfirmasi Password Baru
                        </label>

                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">

                        @error('password_confirmation', 'updatePassword')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Tombol --}}
                    <div class="flex justify-end pt-2">

                        <button type="submit"
                            class="bg-slate-900 hover:bg-slate-800 text-white rounded-xl px-6 py-3 font-semibold">
                            Ubah Password
                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- Hapus Akun --}}
        <div class="bg-white border border-red-200 rounded-2xl p-7">

            <div class="mb-6">

                <h3 class="text-lg font-bold text-red-700">
                    Hapus Akun
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Setelah akun dihapus, seluruh data akun tidak dapat dipulihkan.
                </p>

            </div>


            <form method="POST" action="{{ route('profile.destroy') }}"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">

                @csrf
                @method('DELETE')


                <div class="flex justify-end">

                    <button type="submit"
                        class="border border-red-300 text-red-600 hover:bg-red-50 rounded-xl px-6 py-3 font-semibold">
                        Hapus Akun
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
