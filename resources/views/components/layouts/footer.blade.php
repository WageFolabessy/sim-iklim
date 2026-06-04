<footer class="bg-sky-900 text-sky-100 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div>
            <h3 class="font-semibold text-white mb-2">SIM Iklim BMKG Kalbar</h3>
            <p class="text-sm text-sky-300 leading-relaxed">
                Sistem Informasi Monitoring Iklim milik Stasiun Klimatologi Kalimantan Barat.
            </p>
        </div>
        <div>
            <h3 class="font-semibold text-white mb-2">Tautan Cepat</h3>
            <ul class="space-y-1 text-sm">
                <li><a href="{{ route('home') }}" class="text-sky-300 hover:text-white transition-colors">Beranda</a></li>
                <li><a href="{{ route('climate-data') }}" class="text-sky-300 hover:text-white transition-colors">Data Iklim</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold text-white mb-2">Kontak</h3>
            <p class="text-sm text-sky-300">BMKG Stasiun Klimatologi Kalimantan Barat</p>
        </div>
    </div>
    <div class="border-t border-sky-800 py-4 flex flex-col items-center justify-center gap-2 text-xs text-sky-400">
        <p>&copy; {{ date('Y') }} BMKG Stasiun Klimatologi Kalimantan Barat. Semua hak dilindungi.</p>
        <a href="{{ route('login') }}" class="text-sky-500 hover:text-sky-300 transition-colors">Login Petugas BMKG</a>
    </div>
</footer>
