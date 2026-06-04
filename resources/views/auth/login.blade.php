<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0369a1">

    <title>Masuk — Website Informasi Iklim Interaktif BMKG Kalbar</title>
    <meta name="description" content="Masuk ke panel Website Informasi Iklim Interaktif BMKG Stasiun Klimatologi Kalimantan Barat.">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/bmkg-logo.png" type="image/png">

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
            <div class="inline-flex items-center justify-center mb-5">
                <img src="/bmkg-logo.png" alt="BMKG Logo" class="h-16 w-auto object-contain">
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Masuk ke Sistem</h1>
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
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-sky-500',
                            'border-red-400 bg-red-50' => $errors->has('email'),
                            'border-gray-300 bg-white' => !$errors->has('email'),
                        ])
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
                        @class([
                            'w-full rounded-xl border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-sky-500',
                            'border-red-400 bg-red-50' => $errors->has('password'),
                            'border-gray-300 bg-white' => !$errors->has('password'),
                        ])
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
