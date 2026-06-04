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
            <a href="{{ request()->routeIs('home') ? '#lapor' : route('home') . '#lapor' }}"
               class="hover:text-sky-200 transition-colors">
                Laporkan Cuaca
            </a>

        </div>
    </nav>
</header>
