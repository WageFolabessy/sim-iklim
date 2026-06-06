import './echo';

/**
 * ---------------------------------------------------------------------------
 * Shared toast helper
 * ---------------------------------------------------------------------------
 * Creates an accessible, auto-dismissing toast notification anchored to the
 * bottom-right corner.  Each variant (warning, info, admin) has its own
 * colour palette and icon.
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(text ?? ''));
    return div.innerHTML;
}

const TOAST_ICONS = {
    warning:
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />' +
        '</svg>',
    info:
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
            '<path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />' +
        '</svg>',
    admin:
        '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
            '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />' +
        '</svg>',
};

const TOAST_THEMES = {
    warning: {
        bg: 'bg-orange-600',
        text: 'text-white',
        iconBg: 'bg-white/20',
        subtitle: 'text-orange-100',
        close: 'text-white/70 hover:text-white',
    },
    info: {
        bg: 'bg-sky-600',
        text: 'text-white',
        iconBg: 'bg-white/20',
        subtitle: 'text-sky-100',
        close: 'text-white/70 hover:text-white',
    },
    admin: {
        bg: 'bg-violet-600',
        text: 'text-white',
        iconBg: 'bg-white/20',
        subtitle: 'text-violet-100',
        close: 'text-white/70 hover:text-white',
    },
};

/**
 * @param {'warning'|'info'|'admin'} variant
 * @param {string} title
 * @param {string} subtitle
 * @param {number} autoDismissMs
 * @param {string|null} actionLabel   Optional button label (e.g. "Muat ulang")
 * @param {Function|null} actionFn    Callback when the action button is clicked
 */
function showToast(variant, title, subtitle, autoDismissMs = 10000, actionLabel = null, actionFn = null) {
    const theme = TOAST_THEMES[variant] ?? TOAST_THEMES.info;
    const icon = TOAST_ICONS[variant] ?? TOAST_ICONS.info;

    const toast = document.createElement('div');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.className = [
        'fixed', 'bottom-5', 'right-5', 'z-[9999]',
        'max-w-sm', 'w-full',
        theme.bg, theme.text,
        'rounded-2xl', 'shadow-lg',
        'p-4',
        'flex', 'items-start', 'gap-3',
        'animate-[slideUp_0.3s_ease-out]',
    ].join(' ');

    let actionHtml = '';
    if (actionLabel) {
        actionHtml =
            '<button data-toast-action class="mt-1.5 inline-flex items-center rounded-lg bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur transition hover:bg-white/30 cursor-pointer">' +
                escapeHtml(actionLabel) +
            '</button>';
    }

    toast.innerHTML =
        '<div class="shrink-0 ' + theme.iconBg + ' rounded-lg p-1.5">' +
            icon +
        '</div>' +
        '<div class="flex-1 min-w-0">' +
            '<p class="font-semibold text-sm leading-snug">' + escapeHtml(title) + '</p>' +
            '<p class="text-xs ' + theme.subtitle + ' mt-0.5 leading-relaxed">' + subtitle + '</p>' +
            actionHtml +
        '</div>' +
        '<button data-toast-close class="shrink-0 ' + theme.close + ' transition-colors cursor-pointer" aria-label="Tutup notifikasi">' +
            '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
                '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />' +
            '</svg>' +
        '</button>';

    // Wire close button
    toast.querySelector('[data-toast-close]')
        .addEventListener('click', () => toast.remove());

    // Wire action button
    if (actionLabel && actionFn) {
        toast.querySelector('[data-toast-action]')
            .addEventListener('click', actionFn);
    }

    document.body.appendChild(toast);

    if (autoDismissMs > 0) {
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, autoDismissMs);
    }
}

/**
 * ---------------------------------------------------------------------------
 * Global Echo listeners
 * ---------------------------------------------------------------------------
 */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.Echo === 'undefined') {
        return;
    }

    const userRole = document.querySelector('meta[name="user-role"]')?.content ?? 'guest';
    const currentPath = window.location.pathname;

    // ----- Channel: weather-alerts (all users) ----------------------------
    window.Echo.channel('weather-alerts')
        .listen('WeatherAlertBroadcasted', function (event) {
            const alert = event.alert;
            showToast(
                'warning',
                'PERINGATAN CUACA BARU: ' + (alert.title ?? ''),
                '<strong>' + escapeHtml(alert.area ?? '') + '</strong> — ' + escapeHtml(alert.body ?? ''),
                15000
            );
        });

    // ----- Channel: climate-data (all users) ------------------------------
    window.Echo.channel('climate-data')
        .listen('ClimateDataPublished', function () {
            const isStatistikPage = currentPath === '/statistik';

            showToast(
                'info',
                'Data Iklim Terbaru',
                escapeHtml('Data statistik iklim terbaru telah diterbitkan BMKG.'),
                12000,
                isStatistikPage ? 'Muat ulang halaman' : null,
                isStatistikPage ? function () { window.location.reload(); } : null
            );
        });

    // ----- Channel: citizen-reports (admin only) --------------------------
    if (userRole === 'admin') {
        window.Echo.channel('citizen-reports')
            .listen('CitizenReportSubmitted', function (event) {
                const report = event.citizenReport ?? event.citizen_report ?? {};
                showToast(
                    'admin',
                    'Laporan Warga Baru',
                    escapeHtml('Laporan cuaca warga baru masuk dari ' + (report.location ?? 'lokasi tidak diketahui') + '.'),
                    10000
                );
            });
    }
});
