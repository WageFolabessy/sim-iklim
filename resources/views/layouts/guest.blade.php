<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0ea5e9">

    <title>@yield('title', 'Informasi Iklim') — SIM Iklim BMKG Kalbar</title>
    <meta name="description" content="@yield('description', 'Informasi iklim terkini Kalimantan Barat dari BMKG Stasiun Klimatologi.')">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Service Worker registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .catch(function (err) { console.error('SW registration failed:', err); });
        }
    </script>
</head>
<body class="h-full flex flex-col bg-white text-gray-900 antialiased">

    {{-- Navigation --}}
    <header class="bg-sky-700 text-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-lg font-semibold tracking-tight">SIM Iklim</span>
                <span class="text-sky-200 text-sm font-normal hidden sm:inline">BMKG Kalbar</span>
            </a>

            <div class="flex items-center gap-5 text-sm">
                <a href="{{ route('home') }}" class="hover:text-sky-200 transition-colors">
                    Beranda
                </a>
                <a href="{{ route('climate-data') }}" class="hover:text-sky-200 transition-colors">
                    Data Iklim
                </a>
                <a href="{{ route('citizen-reports.store') }}"
                   onclick="event.preventDefault(); document.getElementById('report-form-anchor') && document.getElementById('report-form-anchor').scrollIntoView({behavior:'smooth'})"
                   class="hover:text-sky-200 transition-colors">
                    Laporkan Cuaca
                </a>
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-white text-sky-700 font-medium hover:bg-sky-50 px-3 py-1.5 rounded-md transition-colors">
                        Masuk
                    </a>
                @endguest
            </div>
        </nav>
    </header>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-sky-900 text-sky-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div>
                <h3 class="font-semibold text-white mb-2">SIM Iklim BMKG Kalbar</h3>
                <p class="text-sm text-sky-300 leading-relaxed">
                    Sistem Informasi Monitoring Iklim milik Stasiun Klimatologi Kalimantan Barat.
                </p>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-2">Tautan Cepat</h3>
                <ul class="space-y-1 text-sm">
                    <li><a href="{{ route('home') }}" class="text-sky-300 hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('climate-data') }}" class="text-sky-300 hover:text-white transition-colors">Data Iklim</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-white mb-2">Kontak</h3>
                <p class="text-sm text-sky-300">BMKG Stasiun Klimatologi Kalimantan Barat</p>
            </div>
        </div>
        <div class="border-t border-sky-800 py-4 text-center text-xs text-sky-400">
            &copy; {{ date('Y') }} BMKG Stasiun Klimatologi Kalimantan Barat. Semua hak dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
