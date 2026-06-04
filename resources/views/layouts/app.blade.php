<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f172a">

    <title>@yield('title', 'Dasbor') — SIM Iklim BMKG Kalbar</title>
    <meta name="description" content="@yield('description', 'Sistem Informasi Monitoring Iklim BMKG Stasiun Klimatologi Kalimantan Barat')">

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
{{-- Full-height flex row: sidebar + content column --}}
<body class="h-full bg-gray-100 text-gray-900 antialiased">

    {{-- =====================================================================
         SIDEBAR OVERLAY — mobile backdrop (hidden by default)
    ====================================================================== --}}
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-20 bg-black/50 hidden md:hidden"
        onclick="closeSidebar()"
        aria-hidden="true"
    ></div>

    {{-- =====================================================================
         SIDEBAR
    ====================================================================== --}}
    <aside
        id="sidebar"
        class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col bg-slate-900 text-slate-100 shadow-xl
               -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out"
        aria-label="Navigasi utama"
    >
        {{-- Brand --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-700/60">
            <div class="flex items-center justify-center bg-sky-500 rounded-xl w-9 h-9 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 0 0 4.5 4.5H18a3.75 3.75 0 0 0 1.332-7.257 3 3 0 0 0-3.758-3.848 5.25 5.25 0 0 0-10.233 2.33A4.502 4.502 0 0 0 2.25 15Z" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-white tracking-tight leading-none">SIM Iklim</p>
                <p class="text-xs text-slate-400 mt-0.5 truncate">BMKG Kalbar</p>
            </div>
        </div>

        {{-- Navigation links --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            {{-- Label --}}
            <p class="px-3 pt-1 pb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">Menu</p>

            @auth
                @if (auth()->user()->isAdmin())
                    {{-- Admin: overview --}}
                    <a href="{{ route('admin.citizen-reports.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('admin.*') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        onclick="closeSidebar()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        Moderasi & Peringatan
                    </a>
                @endif

                @if (auth()->user()->isPengamat())
                    {{-- Pengamat: dashboard --}}
                    <a href="{{ route('pengamat.dashboard') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('pengamat.dashboard') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        onclick="closeSidebar()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12 11.204 3.045c.209-.202.499-.314.796-.314s.587.112.796.314L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dasbor
                    </a>

                    {{-- Pengamat: climate records --}}
                    <a href="{{ route('pengamat.climate-records.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
                               {{ request()->routeIs('pengamat.climate-records.*') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        onclick="closeSidebar()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                        Input Data Iklim
                    </a>
                @endif
            @endauth

            {{-- Divider --}}
            <div class="pt-4 mt-4 border-t border-slate-700/60">
                <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">Umum</p>

                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-colors"
                    target="_blank"
                    onclick="closeSidebar()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253" />
                    </svg>
                    Portal Publik
                </a>
            </div>
        </nav>

        {{-- User info + Logout --}}
        @auth
        <div class="border-t border-slate-700/60 px-3 py-4">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="flex items-center justify-center bg-sky-600 rounded-full w-8 h-8 shrink-0 text-xs font-bold text-white uppercase">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role->value }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-300 hover:bg-red-600/20 hover:text-red-300 transition-colors cursor-pointer"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
        @endauth
    </aside>

    {{-- =====================================================================
         MAIN AREA — offset on md+ to leave room for sidebar
    ====================================================================== --}}
    <div class="flex flex-col min-h-screen md:pl-64">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6">

                {{-- Hamburger (mobile only) --}}
                <button
                    id="sidebar-toggle"
                    type="button"
                    class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer"
                    aria-label="Buka menu navigasi"
                    onclick="openSidebar()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                {{-- Page title (yielded per view, falls back to generic) --}}
                <h1 class="text-base font-semibold text-gray-800 hidden md:block">
                    @yield('page-title', 'Dasbor')
                </h1>

                {{-- Right: user badge --}}
                @auth
                <div class="flex items-center gap-2 ml-auto">
                    <div class="flex items-center justify-center bg-sky-600 rounded-full w-8 h-8 text-xs font-bold text-white uppercase shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-gray-800 leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize mt-0.5">{{ auth()->user()->role->value }}</p>
                    </div>
                </div>
                @endauth
            </div>
        </header>

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
        <main class="flex-1 px-4 sm:px-6 py-8">
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
