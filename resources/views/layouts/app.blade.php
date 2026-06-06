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

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('title', 'Dasbor') — Website Informasi Iklim Interaktif BMKG Kalbar">
    <meta property="og:description" content="@yield('description', 'Sistem Informasi Monitoring Iklim BMKG Stasiun Klimatologi Kalimantan Barat')">
    <meta property="og:image" content="{{ asset('bmkg-logo.png') }}">
    <meta property="og:site_name" content="SIM Iklim BMKG Kalbar">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ request()->url() }}">
    <meta name="twitter:title" content="@yield('title', 'Dasbor') — Website Informasi Iklim Interaktif BMKG Kalbar">
    <meta name="twitter:description" content="@yield('description', 'Sistem Informasi Monitoring Iklim BMKG Stasiun Klimatologi Kalimantan Barat')">
    <meta name="twitter:image" content="{{ asset('bmkg-logo.png') }}">

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

        {{-- Floating Toast Notifications --}}
        @if (session('success') || session('error'))
        <div id="flash-toast-admin" class="fixed bottom-6 left-1/2 -translate-x-1/2 sm:left-auto sm:translate-x-0 sm:right-6 z-50 w-[calc(100%-2rem)] max-w-sm sm:w-auto">
            <div class="flex items-start gap-3 rounded-2xl border p-4 shadow-xl backdrop-blur-lg transition-all duration-300
                {{ session('success') ? 'bg-emerald-50/95 border-emerald-200 text-emerald-800' : 'bg-red-50/95 border-red-200 text-red-800' }}">
                @if(session('success'))
                <div class="shrink-0 grid h-8 w-8 place-items-center rounded-lg bg-emerald-100 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m4.5 12.75 6 6 9-13.5"/></svg>
                </div>
                @else
                <div class="shrink-0 grid h-8 w-8 place-items-center rounded-lg bg-red-100 text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="15" x2="9" y1="9" y2="15"/><line x1="9" x2="15" y1="9" y2="15"/></svg>
                </div>
                @endif
                <p class="flex-1 text-sm font-medium leading-snug">{{ session('success') ?? session('error') }}</p>
                <button onclick="document.getElementById('flash-toast-admin').remove()" class="shrink-0 opacity-60 hover:opacity-100 transition cursor-pointer" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
        <script>setTimeout(function(){var t=document.getElementById('flash-toast-admin');if(t)t.remove();},5000);</script>
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
