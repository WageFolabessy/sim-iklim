<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0369a1">

    <title>Masuk — SIM Iklim BMKG Kalbar</title>
    <meta name="description" content="Masuk ke panel SIM Iklim BMKG Stasiun Klimatologi Kalimantan Barat.">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/icons/icon.svg" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .catch(function (err) { console.error('SW registration failed:', err); });
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50 antialiased">

    <div class="w-full max-w-md px-4 py-12">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-sky-600 rounded-2xl w-16 h-16 mb-5 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Masuk ke SIM Iklim</h1>
            <p class="text-sm text-gray-500 mt-1.5">BMKG Stasiun Klimatologi Kalimantan Barat</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 px-8 py-8">

            {{-- Credential error --}}
            @if ($errors->has('email'))
                <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    {{ $errors->first('email') }}
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
                </div>

                {{-- Password --}}
                <div class="mb-7">
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
                    class="w-full bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold py-3 rounded-xl shadow-sm transition-colors cursor-pointer text-sm"
                >
                    Masuk ke Panel
                </button>
            </form>
        </div>

        {{-- Footer note --}}
        <div class="mt-6 text-center space-y-1">
            <p class="text-xs text-gray-400">Akun dikelola oleh administrator sistem.</p>
            <a href="{{ route('home') }}" class="text-xs text-sky-500 hover:text-sky-700 transition-colors">
                ← Kembali ke Portal Publik
            </a>
        </div>
    </div>

</body>
</html>
