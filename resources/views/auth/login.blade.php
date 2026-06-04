@extends('layouts.guest')

@section('title', 'Masuk')
@section('description', 'Masuk ke panel SIM Iklim BMKG Stasiun Klimatologi Kalimantan Barat.')

@section('content')
<section class="flex-grow flex items-center justify-center min-h-[80vh] px-4 py-12">
    <div class="w-full max-w-md">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-sky-600 rounded-2xl w-14 h-14 mb-4 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Masuk ke SIM Iklim</h1>
            <p class="text-sm text-gray-500 mt-1">BMKG Stasiun Klimatologi Kalimantan Barat</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">

            {{-- Global error (wrong credentials) --}}
            @if ($errors->any() && ! $errors->has('email') && ! $errors->has('password'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Alamat Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        autofocus
                        required
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-sky-500 @error('email') border-red-400 bg-red-50 @else border-gray-300 bg-white @enderror"
                        placeholder="nama@bmkg.go.id"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-sky-500 @error('password') border-red-400 bg-red-50 @else border-gray-300 bg-white @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold py-2.5 rounded-xl shadow-sm transition-colors cursor-pointer"
                >
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            Akun dikelola oleh administrator sistem.
        </p>
    </div>
</section>
@endsection
