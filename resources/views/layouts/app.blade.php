<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0ea5e9">

    <title>@yield('title', 'Dasbor') — SIM Iklim BMKG Kalbar</title>
    <meta name="description" content="@yield('description', 'Sistem Informasi Monitoring Iklim BMKG Stasiun Klimatologi Kalimantan Barat')">

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
<body class="h-full flex flex-col bg-gray-50 text-gray-900 antialiased">

    {{-- Navigation --}}
    <header class="bg-sky-700 text-white shadow-md">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-semibold tracking-tight">
                <span class="text-white">SIM Iklim</span>
                <span class="text-sky-200 text-sm font-normal hidden sm:inline">BMKG Kalbar</span>
            </a>

            <div class="flex items-center gap-4 text-sm">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.citizen-reports.index') }}" class="hover:text-sky-200 transition-colors">
                            Laporan Warga
                        </a>
                    @endif

                    @if(auth()->user()->isPengamat())
                        <a href="{{ route('pengamat.climate-records.index') }}" class="hover:text-sky-200 transition-colors">
                            Data Iklim
                        </a>
                    @endif

                    <span class="text-sky-300">{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-sky-800 hover:bg-sky-900 px-3 py-1.5 rounded-md transition-colors cursor-pointer">
                            Keluar
                        </button>
                    </form>
                @endauth
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
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} BMKG Stasiun Klimatologi Kalimantan Barat. Semua hak dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
