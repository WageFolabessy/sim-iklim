<footer class="mt-24 border-t border-border bg-surface">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
        <div class="grid gap-8 md:grid-cols-3">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="shrink-0 flex items-center justify-center">
                        <img src="/bmkg-logo.png" alt="BMKG Logo" class="h-10 w-auto object-contain">
                    </div>
                    <span class="font-display text-base font-bold text-foreground">IklimKalbar</span>
                </div>
                <p class="mt-3 max-w-xs text-sm text-muted-foreground">
                    Portal informasi iklim & cuaca resmi untuk petani, nelayan, dan masyarakat Kalimantan Barat.
                </p>
            </div>
            <div>
                <div class="text-sm font-semibold text-foreground">Layanan</div>
                <ul class="mt-3 space-y-2 text-sm text-muted-foreground">
                    <li><a href="{{ route('statistik') }}" class="hover:text-foreground transition-colors">Data iklim harian</a></li>
                    <li><a href="{{ route('statistik') }}" class="hover:text-foreground transition-colors">Proyeksi statistik historis</a></li>
                    <li>Peringatan dini cuaca ekstrem</li>
                    <li><a href="{{ request()->routeIs('home') ? '#lapor' : route('home') . '#lapor' }}" class="hover:text-foreground transition-colors">Laporan cuaca warga</a></li>
                </ul>
            </div>
            <div>
                <div class="text-sm font-semibold text-foreground">Kontak</div>
                <ul class="mt-3 space-y-2 text-sm text-muted-foreground">
                    <li>Stasiun PMG Kalbar</li>
                    <li>Jl. Adisucipto Km. 17, Pontianak</li>
                    <li>info@iklimkalbar.id</li>
                </ul>
            </div>
        </div>
        <div class="mt-10 border-t border-border pt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-muted-foreground">
            <div>© {{ date('Y') }} Pusat Meteorologi & Geofisika Kalimantan Barat. Data resmi PMG.</div>
            <a href="{{ route('login') }}" class="hover:text-foreground transition-colors">Login Petugas</a>
        </div>
    </div>
</footer>
