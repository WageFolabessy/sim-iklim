<footer class="mt-24 border-t border-border bg-surface">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
        <div class="flex flex-col md:flex-row gap-8 md:justify-between">
            <div>
                <div class="flex items-center gap-2.5">
                    <div class="shrink-0 flex items-center justify-center">
                        <img src="/bmkg-logo.png" alt="BMKG Logo" class="h-10 w-auto object-contain">
                    </div>
                    <span class="font-display text-base font-bold text-foreground">Iklim Interaktif</span>
                </div>
                <p class="mt-3 text-sm text-muted-foreground">
                    Portal informasi iklim & cuaca resmi untuk petani, nelayan, dan masyarakat Kalimantan Barat.
                </p>
            </div>
            <div class="md:text-right">
                <div class="text-sm font-semibold text-foreground">Layanan</div>
                <ul class="mt-3 space-y-2 text-sm text-muted-foreground">
                    <li><a href="{{ route('statistik') }}" class="hover:text-foreground transition-colors">Data iklim & statistik</a></li>
                    <li><a href="{{ route('peringatan') }}" class="hover:text-foreground transition-colors">Peringatan dini cuaca ekstrem</a></li>
                    <li><a href="{{ route('laporkan') }}" class="hover:text-foreground transition-colors">Laporan cuaca warga</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-10 border-t border-border pt-6 text-center text-xs text-muted-foreground">
            © {{ date('Y') }} Pusat Meteorologi & Geofisika Kalimantan Barat. Data resmi PMG.
        </div>
    </div>
</footer>
