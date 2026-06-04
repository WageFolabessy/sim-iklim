<header class="sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">

        {{-- Hamburger (mobile only) --}}
        <button
            id="sidebar-toggle"
            type="button"
            class="md:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer"
            aria-label="Buka menu navigasi"
            aria-expanded="false"
            onclick="openSidebar()"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        {{-- Page title --}}
        <h1 class="text-base font-semibold text-gray-800 hidden md:block">
            @yield('page-title', 'Dasbor')
        </h1>

        {{-- User badge --}}
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
