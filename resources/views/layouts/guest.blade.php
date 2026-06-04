<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0ea5e9">

    <title>@yield('title', 'Informasi Iklim') — SIM Iklim BMKG Kalbar</title>
    <meta name="description" content="@yield('description', 'Informasi iklim terkini Kalimantan Barat dari BMKG Stasiun Klimatologi.')">

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/icons/icon.svg" type="image/svg+xml">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Service Worker registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .catch(function (err) { console.error('SW registration failed:', err); });
        }
    </script>
</head>
<body class="h-full flex flex-col bg-white text-gray-900 antialiased">

    {{-- Navigation --}}
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
                <a href="{{ route('citizen-reports.store') }}"
                   onclick="event.preventDefault(); document.getElementById('report-form-anchor') && document.getElementById('report-form-anchor').scrollIntoView({behavior:'smooth'})"
                   class="hover:text-sky-200 transition-colors">
                    Laporkan Cuaca
                </a>
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-white text-sky-700 font-medium hover:bg-sky-50 px-3 py-1.5 rounded-md transition-colors">
                        Masuk
                    </a>
                @endguest
            </div>
        </nav>
    </header>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
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
        <div class="border-t border-sky-800 py-4 text-center text-xs text-sky-400">
            &copy; {{ date('Y') }} BMKG Stasiun Klimatologi Kalimantan Barat. Semua hak dilindungi.
        </div>
    </footer>

    @stack('scripts')

    {{-- Real-time weather alert listener (all public pages) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Echo === 'undefined') {
                return;
            }

            window.Echo.channel('weather-alerts')
                .listen('WeatherAlertBroadcasted', function (event) {
                    showWeatherAlertToast(event.message);
                });

            function showWeatherAlertToast(message) {
                var toast = document.createElement('div');
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.className = [
                    'fixed', 'bottom-5', 'right-5', 'z-50',
                    'max-w-sm', 'w-full',
                    'bg-orange-600', 'text-white',
                    'rounded-2xl', 'shadow-lg',
                    'p-4',
                    'flex', 'items-start', 'gap-3',
                    'transition-all', 'duration-300',
                ].join(' ');

                toast.innerHTML =
                    '<div class="shrink-0 bg-white/20 rounded-lg p-1.5">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />' +
                        '</svg>' +
                    '</div>' +
                    '<div class="flex-1 min-w-0">' +
                        '<p class="font-semibold text-sm leading-snug">Peringatan Cuaca Ekstrem</p>' +
                        '<p class="text-xs text-orange-100 mt-0.5 leading-relaxed">' + escapeHtml(message) + '</p>' +
                    '</div>' +
                    '<button onclick="this.parentElement.remove()" class="shrink-0 text-white/70 hover:text-white transition-colors cursor-pointer" aria-label="Tutup peringatan">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
                            '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />' +
                        '</svg>' +
                    '</button>';

                document.body.appendChild(toast);

                // Auto-dismiss after 10 seconds
                setTimeout(function () {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 10000);
            }

            function escapeHtml(text) {
                var div = document.createElement('div');
                div.appendChild(document.createTextNode(text));
                return div.innerHTML;
            }
        });
    </script>
</body>
</html>
