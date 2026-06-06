<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0ea5e9">
    <meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">

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
                    showWeatherAlertToast(event.alert);
                });

            function showWeatherAlertToast(alert) {
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
                        '<p class="font-semibold text-sm leading-snug">Peringatan: ' + escapeHtml(alert.title) + '</p>' +
                        '<p class="text-xs text-orange-100 mt-0.5 leading-relaxed"><strong>' + escapeHtml(alert.area) + '</strong> - ' + escapeHtml(alert.body) + '</p>' +
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

    {{-- Global Push Notification Soft-Prompt Banner --}}
    <div id="push-prompt-banner" class="fixed bottom-0 inset-x-0 z-50 hidden">
        <div class="mx-auto max-w-2xl px-4 pb-4 sm:pb-6">
            <div class="rounded-2xl border border-border/60 bg-card/95 p-4 shadow-xl backdrop-blur-lg sm:flex sm:items-center sm:gap-4">
                <div class="flex items-start gap-3 sm:flex-1">
                    <div class="shrink-0 grid h-10 w-10 place-items-center rounded-xl bg-primary/10 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-foreground">Peringatan Cuaca Ekstrem</p>
                        <p class="mt-0.5 text-xs text-muted-foreground">Dapatkan peringatan dini cuaca ekstrem langsung di perangkat Anda.</p>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-2 sm:mt-0 sm:shrink-0">
                    <button id="push-prompt-dismiss" class="flex-1 sm:flex-none rounded-lg border border-border px-4 py-2 text-xs font-semibold text-muted-foreground transition hover:bg-secondary cursor-pointer">Nanti</button>
                    <button id="push-prompt-activate" class="flex-1 sm:flex-none rounded-lg bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-sm transition hover:opacity-90 cursor-pointer">Aktifkan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Global Push Subscription Logic --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var banner = document.getElementById('push-prompt-banner');
        var btnActivate = document.getElementById('push-prompt-activate');
        var btnDismiss = document.getElementById('push-prompt-dismiss');

        if (!banner || !btnActivate || !btnDismiss) return;
        if (!('serviceWorker' in navigator) || !('PushManager' in window) || !('Notification' in window)) return;

        var DISMISS_KEY = 'push_prompt_dismissed_at';
        var DISMISS_DAYS = 3;

        function shouldShowBanner() {
            if (Notification.permission !== 'default') return false;
            var dismissed = localStorage.getItem(DISMISS_KEY);
            if (dismissed) {
                var diff = Date.now() - parseInt(dismissed, 10);
                if (diff < DISMISS_DAYS * 24 * 60 * 60 * 1000) return false;
            }
            return true;
        }

        function urlB64ToUint8Array(base64String) {
            var padding = '='.repeat((4 - base64String.length % 4) % 4);
            var base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
            var rawData = window.atob(base64);
            var outputArray = new Uint8Array(rawData.length);
            for (var i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }

        async function subscribeToPush() {
            try {
                var permission = await Notification.requestPermission();
                if (permission !== 'granted') return;

                var vapidKey = document.querySelector('meta[name="vapid-public-key"]');
                if (!vapidKey) return;

                var swReg = await navigator.serviceWorker.ready;
                var subscription = await swReg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlB64ToUint8Array(vapidKey.content)
                });

                var csrfMeta = document.querySelector('meta[name="csrf-token"]');
                await fetch('{{ route('push.subscribe') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfMeta ? csrfMeta.content : ''
                    },
                    body: JSON.stringify(subscription)
                });
            } catch (err) {
                console.error('Push subscription failed:', err);
            }
        }

        if (shouldShowBanner()) {
            setTimeout(function () {
                banner.classList.remove('hidden');
            }, 2000);
        }

        btnActivate.addEventListener('click', function () {
            banner.classList.add('hidden');
            subscribeToPush();
        });

        btnDismiss.addEventListener('click', function () {
            banner.classList.add('hidden');
            localStorage.setItem(DISMISS_KEY, Date.now().toString());
        });
    });
    </script>
</body>
</html>
