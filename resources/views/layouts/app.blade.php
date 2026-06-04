<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f172a">

    <title>@yield('title', 'Dasbor') — Website Informasi Iklim Interaktif BMKG Kalbar</title>
    <meta name="description" content="@yield('description', 'Sistem Informasi Monitoring Iklim BMKG Stasiun Klimatologi Kalimantan Barat')">

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
{{-- Full-height flex row: sidebar + content column --}}
<body class="h-full bg-gray-100 text-gray-900 antialiased">

    <x-layouts.sidebar />

    {{-- =====================================================================
         MAIN AREA — offset on md+ to leave room for sidebar
    ====================================================================== --}}
    <div class="flex flex-col min-h-screen md:pl-64">

        <x-layouts.topbar />

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="px-4 sm:px-6 pt-4">
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="px-4 sm:px-6 pt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 w-full px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-white">
            <p class="text-xs text-gray-400 text-center">
                &copy; {{ date('Y') }} BMKG Stasiun Klimatologi Kalimantan Barat. Semua hak dilindungi.
            </p>
        </footer>
    </div>

    @stack('scripts')

    {{-- Sidebar toggle — vanilla JS, no framework --}}
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.remove('hidden');
            document.getElementById('sidebar-toggle').setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
            document.getElementById('sidebar-toggle').setAttribute('aria-expanded', 'false');
        }

        // Close sidebar on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeSidebar(); }
        });
    </script>
</body>
</html>
