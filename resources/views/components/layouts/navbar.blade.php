<header class="sticky top-0 z-40 border-b border-border/60 bg-background/80 backdrop-blur-md">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <div class="shrink-0 flex items-center justify-center">
                <img src="/bmkg-logo.png" alt="BMKG Logo" class="h-10 w-auto object-contain">
            </div>
            <div class="leading-tight">
                <div class="font-display text-base font-bold text-foreground">Iklim Interaktif</div>
                <div class="text-[11px] text-muted-foreground">PMG Kalimantan Barat</div>
            </div>
        </a>

        {{-- Desktop Navigation --}}
        <div class="hidden items-center gap-1 md:flex">
            <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground {{ request()->routeIs('home') ? 'bg-secondary text-primary' : '' }}">
                Beranda
            </a>
            <a href="{{ route('statistik') }}" class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground {{ request()->routeIs('statistik') ? 'bg-secondary text-primary' : '' }}">
                Statistik
            </a>
            <a href="{{ route('peringatan') }}" class="rounded-md px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-secondary hover:text-foreground {{ request()->routeIs('peringatan') ? 'bg-secondary text-primary' : '' }}">
                Peringatan
            </a>
            <a href="{{ route('laporkan') }}" class="ml-2 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground shadow-sm transition-all hover:opacity-90">
                Kirim Laporan
            </a>
        </div>

        {{-- Mobile Hamburger Button --}}
        <button id="mobile-menu-btn" class="grid h-10 w-10 place-items-center rounded-md text-foreground md:hidden" aria-label="Toggle menu">
            <svg id="menu-icon-open" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            <svg id="menu-icon-close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 hidden"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </nav>

    {{-- Mobile Menu Drawer --}}
    <div id="mobile-menu" class="hidden border-t border-border bg-background md:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col px-4 py-2">
            <a href="{{ route('home') }}" class="rounded-md px-3 py-3 text-sm font-medium text-foreground hover:bg-secondary">
                Beranda
            </a>
            <a href="{{ route('statistik') }}" class="rounded-md px-3 py-3 text-sm font-medium text-foreground hover:bg-secondary">
                Statistik
            </a>
            <a href="{{ route('peringatan') }}" class="rounded-md px-3 py-3 text-sm font-medium text-foreground hover:bg-secondary">
                Peringatan
            </a>
            <a href="{{ route('laporkan') }}" class="rounded-md px-3 py-3 text-sm font-medium text-foreground hover:bg-secondary">
                Lapor Cuaca
            </a>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        if (btn && menu) {
            btn.addEventListener('click', function () {
                menu.classList.toggle('hidden');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        }
    });
</script>
