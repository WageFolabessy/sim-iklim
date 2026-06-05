<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0ea5e9">

    <title>@yield('title', 'Informasi Iklim') — Website Informasi Iklim Interaktif BMKG Kalbar</title>
    <meta name="description" content="@yield('description', 'Informasi iklim terkini Kalimantan Barat dari BMKG Stasiun Klimatologi.')">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon.svg') }}">
    <link rel="icon" href="/bmkg-logo.png" type="image/png">

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('title', 'Informasi Iklim') — Website Informasi Iklim Interaktif BMKG Kalbar">
    <meta property="og:description" content="@yield('description', 'Informasi iklim terkini Kalimantan Barat dari BMKG Stasiun Klimatologi.')">
    <meta property="og:image" content="{{ asset('bmkg-logo.png') }}">
    <meta property="og:site_name" content="SIM Iklim BMKG Kalbar">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ request()->url() }}">
    <meta name="twitter:title" content="@yield('title', 'Informasi Iklim') — Website Informasi Iklim Interaktif BMKG Kalbar">
    <meta name="twitter:description" content="@yield('description', 'Informasi iklim terkini Kalimantan Barat dari BMKG Stasiun Klimatologi.')">
    <meta name="twitter:image" content="{{ asset('bmkg-logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-background text-foreground font-sans antialiased">

    <x-layouts.navbar />

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
    <main class="grow">
        @yield('content')
    </main>

    <x-layouts.footer />

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

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</body>
</html>
