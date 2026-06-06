@extends('layouts.guest')

@section('title', 'Beranda')
@section('description', 'Informasi iklim terkini dan laporan cuaca dari warga Kalimantan Barat.')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-hero lg:min-h-[85vh] flex items-center">
    <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.15) 0, transparent 40%), radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1) 0, transparent 50%)"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:py-20 w-full">
        <div class="grid gap-8 lg:gap-10 lg:grid-cols-[1.1fr_1fr] lg:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-medium text-white backdrop-blur">
                    <span class="grid h-1.5 w-1.5 place-items-center rounded-full bg-success"></span>
                    Sistem aktif · Diperbarui {{ date('H:i') }}
                </div>
                <h1 class="mt-4 lg:mt-5 font-display text-3xl font-bold leading-[1.05] text-white text-balance sm:text-5xl lg:text-6xl">
                    Website Informasi Iklim Interaktif
                </h1>
                <p class="mt-3 lg:mt-5 max-w-xl text-sm text-white/85 sm:text-lg">
                    Layanan pemantauan data cuaca dan iklim dari BMKG Stasiun Klimatologi Kalimantan Barat untuk petani, nelayan, dan masyarakat umum.
                </p>
                <div class="mt-6 lg:mt-7 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('laporkan') }}" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-primary shadow-glow transition hover:bg-white/95">
                        Kirim Laporan Cuaca
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('statistik') }}" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 rounded-lg border border-white/30 bg-white/5 px-5 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/15">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                        Lihat Data Iklim & Statistik
                    </a>
                </div>
                <div class="mt-8 flex flex-nowrap overflow-x-auto gap-2.5 text-xs text-white/90 pb-2 sm:pb-0 sm:flex-wrap scrollbar-none [&::-webkit-scrollbar]:hidden">
                    <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-1.5 backdrop-blur-md border border-white/15 shadow-sm transition hover:bg-white/20"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M5 13a10 10 0 0 1 14 0"/><path d="M8.5 16.5a5 5 0 0 1 7 0"/><path d="M2 8.82a15 15 0 0 1 20 0"/><line x1="12" x2="12.01" y1="20" y2="20"/></svg> Akses Offline</span>
                    <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-1.5 backdrop-blur-md border border-white/15 shadow-sm transition hover:bg-white/20"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg> Push Notification</span>
                    <span class="shrink-0 inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-1.5 backdrop-blur-md border border-white/15 shadow-sm transition hover:bg-white/20"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg> Install App</span>
                </div>
            </div>

            {{-- Current climate card --}}
            <div id="live-climate-card" class="rounded-2xl border border-white/15 bg-white/10 p-6 backdrop-blur-md shadow-glow transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-xs uppercase tracking-wider text-white/70">Kondisi Saat Ini</div>
                        <div class="mt-1 text-lg font-semibold text-white">
                            {{ $latestRecord ? 'Kalimantan Barat' : 'Belum ada data' }}
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 animate-pulse text-success"><circle cx="12" cy="12" r="2"/><path d="M4.93 19.07a10 10 0 0 1 0-14.14"/><path d="M7.76 16.24a6 6 0 0 1 0-8.48"/><path d="M16.24 7.76a6 6 0 0 1 0 8.48"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                </div>
                <div class="mt-4 flex items-baseline gap-3">
                    <div class="font-display text-7xl font-bold text-white"><span id="live-temp">{{ isset($latestRecord) ? number_format($latestRecord->temperature, 1) : '--' }}</span>°</div>
                    <div class="pb-2 text-sm text-white/80">Suhu Udara</div>
                </div>
                <div class="mt-5 grid grid-cols-2 gap-2.5">
                    <div class="rounded-xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <div class="flex items-center gap-2 text-xs font-medium text-white/80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M12 22a5 5 0 0 0 5-5c0-2-5-10-5-10S7 15 7 17a5 5 0 0 0 5 5Z"/></svg> Kelembapan
                        </div>
                        <div class="mt-2 flex items-baseline gap-1">
                            <span id="live-humidity" class="text-3xl font-bold text-white">{{ $latestRecord->humidity ?? '--' }}</span>
                            <span class="text-sm text-white/70">%</span>
                        </div>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <div class="flex items-center gap-2 text-xs font-medium text-white/80">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M16 14v6"/><path d="M8 14v6"/><path d="M12 16v6"/></svg> Curah Hujan
                        </div>
                        <div class="mt-2 flex items-baseline gap-1">
                            <span id="live-rainfall" class="text-3xl font-bold text-white">{{ isset($latestRecord) ? number_format($latestRecord->rainfall, 1) : '--' }}</span>
                            <span class="text-sm text-white/70">mm</span>
                        </div>
                        <div class="mt-1 text-[11px] text-white/60">24 jam terakhir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    {{-- Active alerts banner --}}
    @if($activeAlerts->isNotEmpty())
    <section class="mx-auto max-w-7xl px-4 sm:px-6 relative z-10">
        <div class="-mt-6 rounded-xl border border-warning/40 bg-gradient-warn p-4 text-warning-foreground shadow-card sm:p-5">
            <div class="flex flex-wrap items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 shrink-0"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                <div class="flex-1">
                    <div class="text-sm font-bold">{{ $activeAlerts->count() }} Peringatan Aktif di Kalimantan Barat</div>
                    <div class="text-xs opacity-80">{{ Str::limit($activeAlerts->first()->title, 50) }}</div>
                </div>
                <a href="{{ route('peringatan') }}" class="rounded-lg bg-foreground/10 px-3 py-1.5 text-xs font-semibold backdrop-blur hover:bg-foreground/20">
                    Lihat detail &rarr;
                </a>
            </div>
        </div>
    </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="font-display text-2xl font-bold sm:text-3xl">Data Pengamatan Terkini</h2>
                <p class="mt-1 text-sm text-muted-foreground">Stasiun Klimatologi Kelas II Kalimantan Barat</p>
            </div>
            <a href="{{ route('statistik') }}" class="inline-flex items-center justify-center w-full sm:w-auto gap-1.5 rounded-lg bg-primary/10 px-4 py-2 text-sm font-semibold text-primary transition hover:bg-primary/20 shrink-0">
                Statistik lengkap
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
        
        @if($latestRecord)
        @php
            $status = ($latestRecord->rainfall > 20 || $latestRecord->temperature > 34) ? 'waspada' : 'normal';
        @endphp
        <div class="mt-6 max-w-2xl">
            <div class="group rounded-xl border border-border bg-card p-6 shadow-card transition hover:-translate-y-0.5 hover:shadow-glow">
                <div class="flex items-center justify-between">
                    <div class="inline-flex items-center gap-1.5 text-sm font-semibold text-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-primary"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg> Stasiun Klimatologi Kelas II Kalimantan Barat
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold uppercase tracking-wider {{ $status === 'waspada' ? 'bg-warning/20 text-warning-foreground' : 'bg-success/15 text-success' }}">
                        {{ $status }}
                    </span>
                </div>
                <div class="mt-6 flex flex-wrap items-end gap-12">
                    <div>
                        <div class="text-sm font-medium text-muted-foreground">Suhu Udara</div>
                        <div class="font-display text-4xl font-bold">{{ number_format($latestRecord->temperature, 1) }}&deg;<span class="text-xl text-muted-foreground">C</span></div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-muted-foreground">Curah Hujan</div>
                        <div class="inline-flex items-center gap-1.5 font-semibold text-info text-2xl font-display">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M16 14v6"/><path d="M8 14v6"/><path d="M12 16v6"/></svg> {{ number_format($latestRecord->rainfall, 1) }} <span class="text-lg">mm</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-muted-foreground">Kecepatan Angin</div>
                        <div class="font-display text-2xl font-bold text-foreground">{{ number_format($latestRecord->wind_speed, 1) }} <span class="text-lg text-muted-foreground">km/h</span></div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-border flex justify-between items-center text-xs text-muted-foreground">
                    <span>Petugas: {{ $latestRecord->user->name ?? 'Pengamat' }}</span>
                    <span>Diperbarui: {{ \Carbon\Carbon::parse($latestRecord->recorded_at)->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        @endif
    </section>

    {{-- Features grid --}}
    <section class="bg-surface py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <h2 class="font-display text-2xl font-bold sm:text-3xl">Untuk siapa portal ini?</h2>
            <p class="mt-1 max-w-2xl text-sm text-muted-foreground">
                Informasi iklim yang ringan, cepat, dan bisa diakses meski sinyal lemah &mdash; dirancang untuk kondisi nyata di lapangan.
            </p>
            
            @php
                $features = [
                    ['title' => 'Petani', 'desc' => 'Jadwal tanam, prakiraan hujan, dan peringatan kekeringan.', 'icon' => '<path d="M14 4v10.54a4 4 0 1 1-4 0V4a2 2 0 0 1 4 0Z"/>'],
                    ['title' => 'Nelayan', 'desc' => 'Kecepatan angin, gelombang, dan jendela aman melaut.', 'icon' => '<path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/>'],
                    ['title' => 'Masyarakat', 'desc' => 'Peringatan dini cuaca ekstrem & info iklim harian.', 'icon' => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>'],
                ];
            @endphp
            
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                @foreach($features as $f)
                    <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                        <div class="grid h-11 w-11 place-items-center rounded-lg bg-primary/10 text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">{!! $f['icon'] !!}</svg>
                        </div>
                        <div class="mt-4 font-display text-lg font-bold">{{ $f['title'] }}</div>
                        <p class="mt-1 text-sm text-muted-foreground">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Live citizen reports --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6">
        <div class="flex items-end justify-between">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-primary">
                    <span class="grid h-2 w-2 place-items-center rounded-full bg-destructive animate-pulse"></span> Live
                </div>
                <h2 class="mt-1 font-display text-2xl font-bold sm:text-3xl">Laporan Cuaca Warga</h2>
                <p class="mt-1 text-sm text-muted-foreground">Disiarkan realtime via Reverb dari masyarakat di lapangan</p>
            </div>
            <a href="{{ route('laporkan') }}" class="hidden rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground sm:inline-flex">
                Kirim Laporan
            </a>
        </div>
        
        @if($recentReports->isNotEmpty())
        <div id="live-reports-container" class="mt-6 divide-y divide-border rounded-xl border border-border bg-card shadow-card">
            @foreach($recentReports as $report)
                @php
                    $anomalyValue = $report->anomaly_type instanceof \App\Enums\AnomalyType ? $report->anomaly_type->value : $report->anomaly_type;
                    $label = match($anomalyValue) {
                        'flood' => 'Banjir',
                        'drought' => 'Kekeringan',
                        'strong_wind' => 'Angin Kencang',
                        default => 'Hujan Lebat/Lainnya'
                    };
                    $badgeClass = match($anomalyValue) {
                        'flood' => 'bg-info/15 text-info',
                        'strong_wind' => 'bg-warning/20 text-warning-foreground',
                        default => 'bg-destructive/15 text-destructive'
                    };
                @endphp
                <div class="flex flex-col sm:flex-row items-start gap-4 p-5">
                    <div class="w-full sm:w-48 shrink-0 pt-1">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badgeClass }}">
                            {{ $label }}
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2 text-sm font-semibold text-foreground">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-muted-foreground"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg> {{ $report->location }}
                        </div>
                        <p class="mt-1 text-sm text-muted-foreground">{{ $report->description }}</p>
                    </div>
                    <div class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> {{ $report->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div id="live-reports-container" class="mt-6 rounded-xl border border-border bg-card p-8 text-center text-sm text-muted-foreground">
            Belum ada laporan cuaca dari warga.
        </div>
        @endif
    </section>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Echo === 'undefined') {
                return;
            }

            var labels = {
                flood: 'Banjir',
                drought: 'Kekeringan',
                strong_wind: 'Angin Kencang',
                heavy_rain: 'Hujan Lebat/Lainnya'
            };

            var badges = {
                flood: 'bg-info/15 text-info',
                strong_wind: 'bg-warning/20 text-warning-foreground'
            };

            var defaultBadge = 'bg-destructive/15 text-destructive';

            window.Echo.channel('citizen-reports')
                .listen('CitizenReportSubmitted', function (event) {
                    var report = event.citizenReport;
                    var type = report.anomaly_type;
                    var label = labels[type] || 'Hujan Lebat/Lainnya';
                    var badgeClass = badges[type] || defaultBadge;

                    var html = '<div class="flex flex-col sm:flex-row items-start gap-4 p-5 live-report-new" style="background: hsl(var(--primary) / 0.04);">' +
                        '<div class="w-full sm:w-48 shrink-0 pt-1">' +
                            '<span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold ' + badgeClass + '">' +
                                label +
                            '</span>' +
                        '</div>' +
                        '<div class="min-w-0 flex-1">' +
                            '<div class="flex flex-wrap items-center gap-2 text-sm font-semibold text-foreground">' +
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-muted-foreground"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg> ' + escapeHtml(report.location) +
                            '</div>' +
                            '<p class="mt-1 text-sm text-muted-foreground">' + escapeHtml(report.description) + '</p>' +
                        '</div>' +
                        '<div class="inline-flex items-center gap-1 text-xs text-muted-foreground">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Baru saja' +
                        '</div>' +
                    '</div>';

                    var container = document.getElementById('live-reports-container');
                    if (!container) {
                        return;
                    }

                    // If container was in empty state, reset it to list mode
                    if (container.classList.contains('text-center')) {
                        container.className = 'mt-6 divide-y divide-border rounded-xl border border-border bg-card shadow-card';
                        container.innerHTML = '';
                    }

                    container.insertAdjacentHTML('afterbegin', html);

                    // Highlight animation
                    var newRow = container.firstElementChild;
                    if (newRow) {
                        setTimeout(function () {
                            newRow.style.transition = 'background 1.5s ease';
                            newRow.style.background = 'transparent';
                        }, 100);
                    }
                });

            window.Echo.channel('climate-data')
                .listen('ClimateDataPublished', function (event) {
                    var record = event.climateRecord;
                    
                    var tempEl = document.getElementById('live-temp');
                    var humEl = document.getElementById('live-humidity');
                    var rainEl = document.getElementById('live-rainfall');
                    var card = document.getElementById('live-climate-card');

                    if (tempEl) tempEl.textContent = parseFloat(record.temperature).toFixed(1);
                    if (humEl) humEl.textContent = record.humidity;
                    if (rainEl) rainEl.textContent = parseFloat(record.rainfall).toFixed(1);

                    if (card) {
                        card.style.background = 'rgba(255, 255, 255, 0.3)';
                        setTimeout(function() {
                            card.style.background = 'rgba(255, 255, 255, 0.1)';
                        }, 300);
                    }
                });

            function escapeHtml(text) {
                var div = document.createElement('div');
                div.appendChild(document.createTextNode(text || ''));
                return div.innerHTML;
            }
        });
    </script>

@endsection
