<header class="bg-sky-700 text-white shadow-sm relative z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="text-lg font-semibold tracking-tight">SIM Iklim</span>
            <span class="text-sky-200 text-sm font-normal hidden sm:inline">BMKG Kalbar</span>
        </a>

        {{-- Desktop Navigation --}}
        <div class="hidden md:flex items-center gap-5 text-sm">
            <a href="{{ route('home') }}" class="hover:text-sky-200 transition-colors">
                Beranda
            </a>
            <a href="{{ route('climate-data') }}" class="hover:text-sky-200 transition-colors">
                Data Iklim
            </a>
            <a href="{{ request()->routeIs('home') ? '#lapor' : route('home') . '#lapor' }}"
               class="hover:text-sky-200 transition-colors">
                Laporkan Cuaca
            </a>
        </div>

        {{-- Mobile Hamburger Button --}}
        <button id="mobile-menu-btn" class="block md:hidden p-2 -mr-2 text-sky-200 hover:text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    {{-- Mobile Menu Drawer --}}
    <div id="mobile-menu" class="hidden md:hidden flex-col bg-sky-700 w-full absolute top-full left-0 px-4 py-4 space-y-4 shadow-md border-t border-sky-600">
        <a href="{{ route('home') }}" class="block text-sm hover:text-sky-200 transition-colors">
            Beranda
        </a>
        <a href="{{ route('climate-data') }}" class="block text-sm hover:text-sky-200 transition-colors">
            Data Iklim
        </a>
        <a href="{{ request()->routeIs('home') ? '#lapor' : route('home') . '#lapor' }}"
           class="block text-sm hover:text-sky-200 transition-colors">
            Laporkan Cuaca
        </a>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
                menu.classList.toggle('flex');
            });
        }
    });
</script>
